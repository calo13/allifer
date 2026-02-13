<?php

namespace App\Livewire\Admin\Pos;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $searchProduct = '';
    public $searchCustomer = '';
    public $selectedCustomer = null;
    public $cart = [];
    public $tipo_documento = 'ticket';
    public $metodo_pago = 'efectivo';
    public $monto_recibido = 0;
    public $vuelto = 0;
    public $showVariantModal = false;
    public $selectedProduct = null;
    public $selectedVariants = [];
    public $variantPrice = 0;
    protected $listeners = ['customerCreated'];

    public function mount()
    {
        // Cliente por defecto: Consumidor Final
        $this->selectedCustomer = [
            'id' => null,
            'nombre' => 'Consumidor Final',
            'nit' => 'CF',
        ];
    }


    public function addToCart($productId)
    {
        $product = Product::with('variants')->findOrFail($productId);

        if ($product->stock <= 0) {
            session()->flash('error', 'Producto sin stock');
            return;
        }

        // Si tiene variantes, abrir modal
        if ($product->variants->count() > 0) {
            $this->openVariantModal($productId);
            return;
        }

        // Sin variantes - agregar directo
        $existingIndex = collect($this->cart)->search(function ($item) use ($productId) {
            return $item['product_id'] == $productId && empty($item['variants']);
        });

        if ($existingIndex !== false) {
            if ($this->cart[$existingIndex]['quantity'] < $product->stock) {
                $this->cart[$existingIndex]['quantity']++;
                $this->cart[$existingIndex]['subtotal'] = $this->cart[$existingIndex]['quantity'] * $this->cart[$existingIndex]['precio_unitario'];
            } else {
                session()->flash('error', 'No hay suficiente stock');
            }
        } else {
            $this->cart[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'precio_unitario' => $product->discount_price,
                'quantity' => 1,
                'subtotal' => $product->discount_price,
                'stock_disponible' => $product->stock,
                'variants' => [],
                'variant_text' => '',
            ];
        }

        $this->searchProduct = '';
        $this->calcularVuelto();
    }



    public function openVariantModal($productId)
    {
        $this->selectedProduct = Product::with('variants')->find($productId);
        $this->selectedVariants = [];
        $this->variantPrice = $this->selectedProduct->discount_price;
        $this->showVariantModal = true;
    }

    public function selectVariant($type, $value, $precioAdicional)
    {
        $this->selectedVariants[$type] = [
            'value' => $value,
            'precio_adicional' => $precioAdicional
        ];
        $this->calculateVariantPrice();
    }

    public function calculateVariantPrice()
    {
        $precio = $this->selectedProduct->discount_price;
        foreach ($this->selectedVariants as $variant) {
            $precio += $variant['precio_adicional'];
        }
        $this->variantPrice = $precio;
    }

    public function addToCartWithVariant()
    {
        if (!$this->selectedProduct) return;

        $product = $this->selectedProduct;

        // Crear texto de variantes
        $variantText = '';
        $variantParts = [];
        foreach ($this->selectedVariants as $type => $data) {
            $variantParts[] = $type . ': ' . $data['value'];
        }
        $variantText = implode(', ', $variantParts);

        // Key único para producto + variantes
        $variantKey = !empty($this->selectedVariants) ? '-' . md5(json_encode($this->selectedVariants)) : '';
        $cartKey = $product->id . $variantKey;

        // Buscar si ya existe
        $existingIndex = collect($this->cart)->search(function ($item) use ($cartKey) {
            return ($item['cart_key'] ?? $item['product_id']) == $cartKey;
        });

        if ($existingIndex !== false) {
            if ($this->cart[$existingIndex]['quantity'] < $product->stock) {
                $this->cart[$existingIndex]['quantity']++;
                $this->cart[$existingIndex]['subtotal'] = $this->cart[$existingIndex]['quantity'] * $this->cart[$existingIndex]['precio_unitario'];
            } else {
                session()->flash('error', 'No hay suficiente stock');
            }
        } else {
            $this->cart[] = [
                'cart_key' => $cartKey,
                'product_id' => $product->id,
                'name' => $product->name,
                'precio_unitario' => $this->variantPrice,
                'quantity' => 1,
                'subtotal' => $this->variantPrice,
                'stock_disponible' => $product->stock,
                'variants' => $this->selectedVariants,
                'variant_text' => $variantText,
            ];
        }

        $this->closeVariantModal();
        $this->searchProduct = '';
        $this->calcularVuelto();
    }

    public function closeVariantModal()
    {
        $this->showVariantModal = false;
        $this->selectedProduct = null;
        $this->selectedVariants = [];
        $this->variantPrice = 0;
    }
    public function removeFromCart($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
        $this->calcularVuelto();
    }

    public function updateQuantity($index, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeFromCart($index);
            return;
        }

        if ($quantity > $this->cart[$index]['stock_disponible']) {
            session()->flash('error', 'No hay suficiente stock');
            return;
        }

        $this->cart[$index]['quantity'] = $quantity;
        $this->cart[$index]['subtotal'] = $quantity * $this->cart[$index]['precio_unitario'];
        $this->calcularVuelto();
    }

    public function selectCustomer($customerId)
    {
        if ($customerId === 'CF') {
            $this->selectedCustomer = [
                'id' => null,
                'nombre' => 'Consumidor Final',
                'nit' => 'CF',
            ];
        } else {
            $customer = Customer::findOrFail($customerId);
            $this->selectedCustomer = [
                'id' => $customer->id,
                'nombre' => $customer->nombre,
                'nit' => $customer->nit,
            ];
        }
        $this->searchCustomer = '';
    }

    public function customerCreated($customerId)
    {
        $this->selectCustomer($customerId);
    }

    public function updatedSearchCustomer()
    {
        if (empty($this->searchCustomer)) {
            return;
        }

        // Si el searchCustomer tiene solo números y tiene al menos 8 dígitos
        if (preg_match('/^\d+$/', $this->searchCustomer) && strlen($this->searchCustomer) >= 8) {
            $customers = Customer::where('activo', true)
                ->where('nit', $this->searchCustomer)
                ->get();

            // Si no encuentra ningún cliente con ese NIT, abrir modal
            if ($customers->isEmpty()) {
                $this->dispatch('openCreateCustomerModal', nit: $this->searchCustomer);
                return;
            }
        }
    }

    public function updatedSearchProduct()
    {
        if (empty($this->searchProduct)) {
            return;
        }

        // Buscar por código de barras exacto
        $product = Product::where('active', true)
            ->where('stock', '>', 0)
            ->where('barcode', $this->searchProduct)
            ->first();

        // Si encuentra el producto por código exacto, agregarlo automáticamente
        if ($product) {
            $this->addToCart($product->id);
        }
    }

    public function updatedMontoRecibido()
    {
        $this->calcularVuelto();
    }

    public function calcularVuelto()
    {
        if ($this->monto_recibido > 0 && !empty($this->cart)) {
            // El total del carrito YA incluye IVA
            $total = collect($this->cart)->sum('subtotal');

            $this->vuelto = $this->monto_recibido - $total;
        } else {
            $this->vuelto = 0;
        }
    }

    public function updatedMetodoPago()
    {
        // Si cambia a tarjeta o transferencia, resetear monto y vuelto
        if ($this->metodo_pago !== 'efectivo') {
            $this->monto_recibido = 0;
            $this->vuelto = 0;
        }
    }

    public function processSale()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'El carrito está vacío');
            return;
        }
        // dd($this->cart);

        // VALIDACIÓN: Si es efectivo, debe ingresar el monto
        if ($this->metodo_pago === 'efectivo') {
            if ($this->monto_recibido <= 0) {
                session()->flash('error', 'Debes ingresar el monto con el que paga el cliente');
                return;
            }

            if ($this->vuelto < 0) {
                session()->flash('error', 'El monto recibido es insuficiente. Falta: Q' . number_format(abs($this->vuelto), 2));
                return;
            }
        }

        if ($this->tipo_documento === 'factura' && $this->selectedCustomer['nit'] === 'CF') {
            session()->flash('error', 'Para factura necesitas un cliente con NIT válido');
            return;
        }

        try {
            DB::beginTransaction();

            $subtotal = collect($this->cart)->sum('subtotal');
            $iva = $subtotal * 0.12;
            $total = $subtotal + $iva;

            // Generar folio único
            $folio = 'V-' . str_pad(Sale::count() + 1, 6, '0', STR_PAD_LEFT);

            // Crear venta
            $sale = Sale::create([
                'folio' => $folio,
                'tipo_venta' => 'presencial',
                'tipo_documento' => $this->tipo_documento,
                'customer_id' => $this->selectedCustomer['id'],
                'nit_cliente' => $this->selectedCustomer['nit'],
                'nombre_cliente' => $this->selectedCustomer['nombre'],
                'subtotal' => $subtotal,
                'iva' => $iva,
                'descuento' => 0,
                'total' => $total,
                'metodo_pago' => $this->metodo_pago,
                'estado' => 'pagado',
                'user_id' => Auth::id(),
                'fecha_venta' => now(),
            ]);

            // Crear items y actualizar stock
            foreach ($this->cart as $item) {
                $product = Product::with('variants')->find($item['product_id']);

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'variants' => !empty($item['variants']) ? json_encode($item['variants']) : null,
                    'variant_text' => $item['variant_text'] ?? null,
                    'quantity' => $item['quantity'],
                    'precio_unitario' => $item['precio_unitario'],
                    'precio_costo' => $product->precio_costo ?? 0,
                    'subtotal' => $item['subtotal'],
                    'descuento' => 0,
                ]);
                // Actualizar stock
                $stockAntes = $product->stock;

                // Si maneja stock por variante, descontar de la variante específica
                if ($product->stock_por_variante && !empty($item['variants'])) {
                    foreach ($item['variants'] as $type => $data) {
                        $variant = $product->variants
                            ->where('type', $type)
                            ->where('value', $data['value'])
                            ->first();

                        if ($variant) {
                            $variant->decrement('stock', $item['quantity']);
                        }
                    }
                    // Recalcular stock total del producto
                    $product->stock = $product->variants->sum('stock');
                    $product->save();
                } else {
                    // Stock normal del producto
                    $product->decrement('stock', $item['quantity']);
                }

                // Registrar movimiento de stock
                $variantInfo = !empty($item['variant_text']) ? ' (' . $item['variant_text'] . ')' : '';
                StockMovement::create([
                    'product_id' => $item['product_id'],
                    'type' => 'salida',
                    'quantity' => -$item['quantity'],
                    'stock_antes' => $stockAntes,
                    'stock_despues' => $product->fresh()->stock,
                    'motivo' => 'Venta #' . $folio . $variantInfo,
                    'user_id' => Auth::id(),
                ]);
            }

            DB::commit();

            // Resetear vuelto
            $this->monto_recibido = 0;
            $this->vuelto = 0;

            session()->flash('sale_id', $sale->id);
            session()->flash('message', 'Venta registrada correctamente: ' . $folio);
            $this->dispatch('open-pdf', saleId: $sale->id);

            // Limpiar carrito
            $this->reset(['cart', 'searchProduct', 'searchCustomer']);
            $this->mount();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al procesar la venta: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $products = Product::with('variants')->where('active', true)
            ->where('stock', '>', 0)
            ->when($this->searchProduct, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->searchProduct . '%')
                        ->orWhere('sku', 'like', '%' . $this->searchProduct . '%')
                        ->orWhere('barcode', 'like', '%' . $this->searchProduct . '%');
                });
            })
            ->limit(10)
            ->get();

        $customers = Customer::where('activo', true)
            ->when($this->searchCustomer, function ($query) {
                $query->where(function ($q) {
                    $q->where('nombre', 'like', '%' . $this->searchCustomer . '%')
                        ->orWhere('nit', 'like', '%' . $this->searchCustomer . '%');
                });
            })
            ->limit(10)
            ->get();

        $total = collect($this->cart)->sum('subtotal');
        $subtotal = $total / 1.12;
        $iva = $total - $subtotal;

        return view('livewire.admin.pos.index', [
            'products' => $products,
            'customers' => $customers,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total,
        ]);
    }
}
