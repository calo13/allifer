<?php

namespace App\Livewire\Shop;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class Cart extends Component
{
    public $cart = [];
    public $showCheckout = false;

    // Datos del cliente
    public $nombre = '';
    public $telefono = '';
    public $email = '';
    public $direccion = '';
    public $notas = '';
    public $tipo_entrega = 'domicilio';

    // Direcciones guardadas
    public $selectedAddressId = null;
    public $showNewAddressForm = false;
    public $newAddressAlias = 'Casa';
    public $newAddressZona = '';
    public $newAddressReferencia = '';
    public $saveNewAddress = true;

    protected $listeners = ['cart-updated' => 'loadCart', 'open-cart' => 'openCart', 'add-to-cart' => 'addToCartFromEvent'];

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'telefono' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
        'direccion' => 'required_if:tipo_entrega,domicilio|string|max:500',
        'notas' => 'nullable|string|max:1000',
        'tipo_entrega' => 'required|in:domicilio,recoger',
    ];

    public function mount()
    {
        $this->loadCart();
        $this->loadUserData();
    }

    public function loadUserData()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $this->nombre = $user->name;
            $this->email = $user->email;
            $this->telefono = $user->telefono ?? '';

            // Cargar dirección por defecto
            $defaultAddress = $user->addresses()->where('is_default', true)->first();
            if ($defaultAddress) {
                $this->selectedAddressId = $defaultAddress->id;
                $this->direccion = $defaultAddress->full_address;
                $this->showNewAddressForm = false;
            } else {
                // Si no tiene direcciones, mostrar formulario de nueva dirección
                $this->showNewAddressForm = true;
            }
        }
    }

    public function loadCart()
    {
        $this->cart = session()->get('cart', []);
    }

    public function selectAddress($addressId)
    {
        if (!auth()->check()) return;

        $address = UserAddress::where('user_id', auth()->id())->find($addressId);
        if ($address) {
            $this->selectedAddressId = $addressId;
            $this->direccion = $address->full_address;
            $this->showNewAddressForm = false;
        }
    }

    public function showNewAddress()
    {
        $this->showNewAddressForm = true;
        $this->selectedAddressId = null;
        $this->direccion = '';
        $this->newAddressAlias = 'Casa';
        $this->newAddressZona = '';
        $this->newAddressReferencia = '';
    }

    public function cancelNewAddress()
    {
        $this->showNewAddressForm = false;
        // Volver a seleccionar la dirección por defecto si existe
        if (auth()->check()) {
            $defaultAddress = auth()->user()->addresses()->where('is_default', true)->first();
            if ($defaultAddress) {
                $this->selectAddress($defaultAddress->id);
            }
        }
    }

    public function addToCart($productId, $quantity = 1, $variants = [], $finalPrice = null)
    {
        if (is_array($productId)) {
            $data = $productId;
            $productId = $data['productId'] ?? null;
            $quantity = $data['quantity'] ?? 1;
            $variants = $data['variants'] ?? [];
            $finalPrice = $data['finalPrice'] ?? null;
        }

        $product = Product::where('active', true)
            ->where('stock', '>', 0)
            ->findOrFail($productId);

        $precio = $finalPrice ?? $product->discount_price;

        $variantKey = !empty($variants) ? '-' . md5(json_encode($variants)) : '';
        $cartKey = $productId . $variantKey;

        $existingIndex = collect($this->cart)->search(function ($item) use ($cartKey) {
            return ($item['cart_key'] ?? $item['product_id']) == $cartKey;
        });

        if ($existingIndex !== false) {
            if ($this->cart[$existingIndex]['quantity'] + $quantity <= $product->stock) {
                $this->cart[$existingIndex]['quantity'] += $quantity;
                $this->cart[$existingIndex]['subtotal'] = $this->cart[$existingIndex]['quantity'] * $this->cart[$existingIndex]['precio'];
            } else {
                session()->flash('error', 'No hay suficiente stock disponible');
                return;
            }
        } else {
            $variantText = '';
            if (!empty($variants)) {
                $variantParts = [];
                foreach ($variants as $type => $value) {
                    $variantParts[] = $type . ': ' . $value;
                }
                $variantText = implode(', ', $variantParts);
            }

            $this->cart[] = [
                'cart_key' => $cartKey,
                'product_id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'precio' => $precio,
                'quantity' => $quantity,
                'subtotal' => $precio * $quantity,
                'image' => $product->image,
                'stock_disponible' => $product->stock,
                'variants' => $variants,
                'variant_text' => $variantText,
            ];
        }

        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
        session()->flash('success', 'Producto agregado al carrito');
    }

    public function removeFromCart($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
    }

    public function updateQuantity($index, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeFromCart($index);
            return;
        }

        if ($quantity > $this->cart[$index]['stock_disponible']) {
            session()->flash('error', 'No hay suficiente stock disponible');
            return;
        }

        $this->cart[$index]['quantity'] = $quantity;
        $this->cart[$index]['subtotal'] = $quantity * $this->cart[$index]['precio'];
        session()->put('cart', $this->cart);
    }

    public function clearCart()
    {
        $this->cart = [];
        session()->forget('cart');
        $this->dispatch('cart-updated');
    }

    public function toggleCheckout()
    {
        $this->showCheckout = !$this->showCheckout;
    }

    public function checkout()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'El carrito está vacío');
            return;
        }

        $total = collect($this->cart)->sum('subtotal');

        $limite = DB::table('shop_settings')->where('key', 'limite_sin_login')->value('value');
        if (!auth()->check() && $total > $limite) {
            session()->flash('error', 'Para pedidos mayores a Q' . number_format($limite, 2) . ' debes iniciar sesión o crear una cuenta.');
            return;
        }

        $maxPedidos = DB::table('shop_settings')->where('key', 'max_pedidos_por_ip')->value('value');
        $ip = Request::ip();
        $pedidosHoy = Order::where('ip_address', $ip)
            ->whereDate('created_at', today())
            ->count();

        if (!auth()->check() && $pedidosHoy >= $maxPedidos) {
            session()->flash('error', 'Has alcanzado el límite de pedidos por día. Por favor, inicia sesión para continuar.');
            return;
        }

        $this->validate();

        try {
            DB::beginTransaction();

            // Guardar teléfono del usuario si está logueado
            if (auth()->check() && $this->telefono) {
                $user = auth()->user();
                if (!$user->telefono || $user->telefono !== $this->telefono) {
                    $user->telefono = $this->telefono;
                    $user->save();
                }
            }

            // Guardar nueva dirección si el usuario está logueado y quiere guardarla
            // Se guarda si: está mostrando el form de nueva dirección O si no tiene direcciones guardadas
            $shouldSaveAddress = auth()->check()
                && $this->saveNewAddress
                && $this->tipo_entrega === 'domicilio'
                && $this->direccion
                && ($this->showNewAddressForm || auth()->user()->addresses()->count() === 0);

            if ($shouldSaveAddress) {
                $isFirst = auth()->user()->addresses()->count() === 0;

                $newAddress = UserAddress::create([
                    'user_id' => auth()->id(),
                    'alias' => $this->newAddressAlias ?: 'Casa',
                    'direccion' => $this->direccion,
                    'zona' => $this->newAddressZona,
                    'referencia' => $this->newAddressReferencia,
                    'is_default' => $isFirst,
                ]);

                $this->selectedAddressId = $newAddress->id;
            }

            // Los precios incluyen IVA, por lo que el subtotal de items es el Total a pagar.
            $totalFinal = collect($this->cart)->sum('subtotal');
            $subtotalNeto = $totalFinal / 1.12;
            $iva = $totalFinal - $subtotalNeto;

            // Crear orden con valores temporales para folio y número
            $order = Order::create([
                'folio' => 'TEMP',
                'order_number' => 'TEMP',
                'tipo' => auth()->check() ? 'registrado' : 'invitado',
                'tipo_entrega' => $this->tipo_entrega,
                'user_id' => auth()->id(),
                'nombre_cliente' => $this->nombre,
                'telefono_cliente' => $this->telefono,
                'email_cliente' => $this->email,
                'direccion_entrega' => $this->direccion,
                'notas' => $this->notas,
                'subtotal' => $subtotalNeto, // Base imponible
                'iva' => $iva,
                'total' => $totalFinal,
                'metodo_pago' => 'efectivo',
                'estado' => 'pendiente',
                'ip_address' => $ip,
                'status_history' => [[
                    'from' => null,
                    'to' => 'pendiente',
                    'notes' => 'Pedido creado',
                    'changed_at' => now()->toDateTimeString(),
                    'changed_by' => auth()->check() ? auth()->user()->name : 'Invitado'
                ]]
            ]);

            // Actualizar con ID real para asegurar unicidad
            $order->folio = 'PED-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
            // Generar número de orden basado en ID (Ej: JP-00504)
            $initials = 'GU';
            if ($this->nombre) {
                $nameParts = explode(' ', trim($this->nombre));
                if (count($nameParts) >= 2) {
                    $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
                } else {
                    $initials = strtoupper(substr($nameParts[0], 0, 2));
                }
            }
            $order->order_number = $initials . '-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
            $order->save();

            foreach ($this->cart as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                if (!$product) {
                    throw new \Exception("El producto {$item['name']} ya no está disponible.");
                }

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("No hay suficiente stock para {$item['name']}. Disponible: {$product->stock}");
                }

                $product->decrement('stock', $item['quantity']);

                // Registrar movimiento de stock
                \App\Models\StockMovement::create([
                    'product_id' => $item['product_id'],
                    'type' => 'salida',
                    'quantity' => -$item['quantity'],
                    'stock_antes' => $product->stock + $item['quantity'],
                    'stock_despues' => $product->stock,
                    'motivo' => 'Pedido Online #' . $order->order_number,
                    'user_id' => auth()->id(),
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'product_sku' => $item['sku'],
                    'precio_unitario' => $item['precio'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            DB::commit();

            $this->clearCart();
            $this->reset(['nombre', 'telefono', 'email', 'direccion', 'notas', 'showCheckout', 'showNewAddressForm']);
            $this->loadUserData();

            session()->flash('success', 'Tu pedido #' . $order->order_number . ' ha sido registrado con éxito.');
            session()->flash('order_number', $order->order_number);

            return redirect()->route('shop.order-success', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al procesar el pedido: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $total = collect($this->cart)->sum('subtotal');
        $subtotal = $total / 1.12;
        $iva = $total - $subtotal;

        $userAddresses = auth()->check() ? auth()->user()->addresses()->latest()->get() : collect();

        return view('livewire.shop.cart', [
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total,
            'userAddresses' => $userAddresses,
        ]);
    }

    public function addToCartFromEvent($productId, $quantity = 1, $variants = [], $finalPrice = null)
    {
        $this->addToCart($productId, $quantity, $variants, $finalPrice);
    }

    public function openCart()
    {
        $this->showCheckout = true;
    }
}
