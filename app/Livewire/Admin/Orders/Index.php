<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $viewMode = 'list'; // 'list' or 'board'
    public $selectedOrderId; // AGREGAR ESTO
    public $selectedOrder = null;
    public $showDetailModal = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = 'all';
        $this->resetPage();
    }

    public function changeStatus($orderId, $newStatus)
    {
        try {
            \Illuminate\Support\Facades\Log::info("Intento cambio estado Orden ID: $orderId a $newStatus");
            DB::beginTransaction();

            $order = Order::with('items.product')->findOrFail($orderId);

            $validStatuses = ['pendiente', 'aprobado', 'en_proceso', 'enviado', 'entregado', 'cancelado'];

            if (!in_array($newStatus, $validStatuses)) {
                session()->flash('error', '❌ Estado no válido');
                return;
            }

            $oldStatus = $order->estado;

            // ✅ SI CAMBIA A "ENTREGADO" → Procesar como venta
            if ($newStatus === 'entregado' && $oldStatus !== 'entregado') {
                \Illuminate\Support\Facades\Log::info("Procesando venta para orden entregada: $order->order_number");

                // Verificamos si la venta ya existe para evitar duplicados
                $existingSale = Sale::where('folio', 'O-' . $order->order_number)->exists();

                if (!$existingSale) {
                    // 0. Buscar o Crear Cliente
                    $customerId = null;

                    if ($order->user_id) {
                        $customer = \App\Models\Customer::where('user_id', $order->user_id)->first();
                    } elseif ($order->email_cliente) {
                        $customer = \App\Models\Customer::where('email', $order->email_cliente)->first();
                    } else {
                        $customer = null;
                    }

                    if ($customer) {
                        $customerId = $customer->id;
                    } else {
                        \Illuminate\Support\Facades\Log::info("Creando nuevo cliente para orden: $order->order_number");
                        // Crear nuevo cliente basado en datos de la orden
                        $newCustomer = \App\Models\Customer::create([
                            'nombre' => $order->nombre_cliente,
                            'email' => $order->email_cliente,
                            'telefono' => $order->telefono_cliente,
                            'direccion' => $order->direccion_entrega,
                            'user_id' => $order->user_id,
                            'nit' => 'CF',
                            'tipo' => 'consumidor_final', // ✅ CORREGIDO: valor válido según migración
                            'activo' => true
                        ]);
                        $customerId = $newCustomer->id;
                    }

                    // 1. Crear la venta en tabla sales
                    $sale = Sale::create([
                        'folio' => 'O-' . $order->order_number,
                        'tipo_venta' => 'online',
                        'tipo_documento' => 'ticket',
                        'customer_id' => $customerId,
                        'nit_cliente' => 'CF',
                        'nombre_cliente' => $order->nombre_cliente,
                        'subtotal' => $order->subtotal,
                        'iva' => $order->iva,
                        'descuento' => $order->descuento,
                        'total' => $order->total,
                        'metodo_pago' => $order->metodo_pago,
                        'estado' => 'pagado',
                        'user_id' => Auth::id(),
                        'fecha_venta' => now(),
                        // 'cash_register_id' => null // Opcional si usas caja
                    ]);

                    // 2. Crear items de venta y actualizar stock
                    foreach ($order->items as $item) {
                        $product = Product::find($item->product_id);

                        if (!$product) continue;

                        // Crear item de venta
                        SaleItem::create([
                            'sale_id' => $sale->id,
                            'product_id' => $item->product_id,
                            'product_name' => $product->name,
                            'quantity' => $item->quantity,
                            'precio_unitario' => $item->precio_unitario,
                            'precio_costo' => $product->precio_costo ?? 0,
                            'subtotal' => $item->precio_unitario * $item->quantity,
                            'descuento' => 0,
                        ]);

                        // Stock ya fue descontado al crear el pedido
                        // No creamos movimiento de stock aquí para evitar duplicados
                        // Solo registramos la venta fiscal
                    }
                } else {
                    \Illuminate\Support\Facades\Log::info("Venta ya existe para orden entregada: $order->order_number. Omitiendo duplicidad.");
                }
            }

            // ✅ SI CAMBIA A "CANCELADO" → Devolver stock
            if ($newStatus === 'cancelado' && $oldStatus !== 'cancelado') {
                \Illuminate\Support\Facades\Log::info("Devolviendo stock para orden cancelada: $order->order_number");

                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if (!$product) continue;

                    $stockAntes = $product->stock;
                    $product->increment('stock', $item->quantity);

                    StockMovement::create([
                        'product_id' => $item->product_id,
                        'type' => 'devolucion',
                        'quantity' => $item->quantity,
                        'stock_antes' => $stockAntes,
                        'stock_despues' => $stockAntes + $item->quantity,
                        'motivo' => 'Cancelación Pedido Online #' . $order->order_number,
                        'user_id' => Auth::id(),
                    ]);
                }
            }

            // Actualizar estado del pedido
            $order->estado = $newStatus;
            $order->save();

            DB::commit();

            $messages = [
                'pendiente' => '🟡 Pedido marcado como pendiente',
                'aprobado' => '✅ Pedido aprobado correctamente',
                'en_proceso' => '🔵 Pedido en preparación',
                'enviado' => '🚚 Pedido marcado como enviado',
                'entregado' => '🟢 Pedido entregado - Stock actualizado y venta registrada',
                'cancelado' => '🔴 Pedido cancelado',
            ];

            session()->flash('success', $messages[$newStatus] ?? '✅ Estado actualizado');
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error("Error cambio estado orden: " . $e->getMessage());
            session()->flash('error', '❌ Error: ' . $e->getMessage());
        }
    }

    public function getStatsProperty()
    {
        return [
            'pending' => Order::where('estado', 'pendiente')->count(),
            'approved' => Order::where('estado', 'aprobado')->count(),
            'processing' => Order::where('estado', 'en_proceso')->count(),
            'shipped' => Order::where('estado', 'enviado')->count(),
            'delivered_today' => Order::where('estado', 'entregado')
                ->whereDate('updated_at', today())
                ->count(),
            'total_today' => Order::whereDate('created_at', today())->sum('total'),
        ];
    }

    public function getOrdersQuery()
    {
        $query = Order::query()
            ->with(['items.product']); // Eager load for performance

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('order_number', 'like', '%' . $this->search . '%')
                    ->orWhere('folio', 'like', '%' . $this->search . '%')
                    ->orWhere('nombre_cliente', 'like', '%' . $this->search . '%')
                    ->orWhere('telefono_cliente', 'like', '%' . $this->search . '%')
                    ->orWhere('email_cliente', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('estado', $this->statusFilter);
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function exportExcel()
    {
        $orders = $this->getOrdersQuery()->get();

        return response()->streamDownload(function () use ($orders) {
            echo '<!DOCTYPE html>
            <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <style>
                    table { border-collapse: collapse; width: 100%; }
                    th, td { border: 1px solid #000000; padding: 5px; text-align: left; }
                    th { background-color: #f2f2f2; font-weight: bold; }
                </style>
            </head>
            <body>
                <table>
                    <thead>
                        <tr>
                            <th>No. Orden</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Dirección</th>
                            <th>Tipo Entrega</th>
                            <th>Método Pago</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($orders as $order) {
                echo '<tr>
                    <td>#' . $order->order_number . '</td>
                    <td>' . $order->created_at->format('d/m/Y H:i') . '</td>
                    <td>' . ($order->nombre_cliente ?: 'Invitado') . '</td>
                    <td>' . $order->telefono_cliente . '</td>
                    <td>' . $order->email_cliente . '</td>
                    <td>' . $order->direccion_entrega . '</td>
                    <td>' . ucfirst($order->tipo_entrega) . '</td>
                    <td>' . ucfirst($order->metodo_pago) . '</td>
                    <td>Q ' . number_format($order->total, 2) . '</td>
                    <td>' . ucfirst($order->estado) . '</td>
                </tr>';
            }

            echo '</tbody>
                </table>
            </body>
            </html>';
        }, 'pedidos-' . date('Y-m-d') . '.xls');
    }

    public function exportPdf()
    {
        $orders = $this->getOrdersQuery()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.orders.pdf', ['orders' => $orders]);
        $pdf->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'pedidos-' . date('Y-m-d') . '.pdf');
    }

    public function render()
    {
        $orders = $this->getOrdersQuery()->paginate(15);

        return view('livewire.admin.orders.index', [
            'orders' => $orders,
            'stats' => $this->stats,
        ]);
    }

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::with('items.product')->find($orderId);
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedOrder = null;
    }
    public function sendEmail($orderId)
    {
        try {
            $order = Order::with('items.product')->findOrFail($orderId);

            if (!$order->email_cliente) {
                session()->flash('error', 'Este pedido no tiene email registrado');
                return;
            }

            // Enviar email
            Mail::to($order->email_cliente)->send(new \App\Mail\OrderDetailsMail($order));

            session()->flash('success', '✉️ Email enviado correctamente a ' . $order->email_cliente);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al enviar email: ' . $e->getMessage());
        }
    }
}
