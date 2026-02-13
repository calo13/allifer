<?php

namespace App\Livewire\Admin\StockControl;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\StockMovement;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['anular-movimiento' => 'anularMovimiento'];

    public $search = '';
    public $filterType = '';
    public $filterDate = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = ['search', 'filterType'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $movements = StockMovement::with(['product', 'user'])
            ->when($this->search, function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterDate, function ($query) {
                $query->whereDate('created_at', $this->filterDate);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(20);

        // Productos con stock bajo
        $lowStockProducts = Product::whereRaw('stock <= stock_minimo')
            ->where('active', true)
            ->get();

        // Productos con variantes
        $productsWithVariants = Product::where('stock_por_variante', true)
            ->where('active', true)
            ->with(['variants' => function ($query) {
                $query->orderBy('type')->orderBy('value');
            }])
            ->get();

        // Estadísticas
        $stats = [
            'total_products' => Product::where('active', true)->count(),
            'low_stock_count' => $lowStockProducts->count(),
            'total_movements_today' => StockMovement::whereDate('created_at', today())->count(),
            'total_inventory_value' => Product::where('active', true)->sum(DB::raw('precio_venta * stock')),
        ];

        return view('livewire.admin.stock-control.index', [
            'movements' => $movements,
            'lowStockProducts' => $lowStockProducts,
            'productsWithVariants' => $productsWithVariants,
            'stats' => $stats,
        ]);
    }

    public function exportExcel()
    {
        $products = Product::where('active', true)->get();
        $productsWithVariants = Product::where('stock_por_variante', true)
            ->where('active', true)
            ->with(['variants' => function ($query) {
                $query->orderBy('type')->orderBy('value');
            }])
            ->get();

        $totalInventoryCost = Product::where('active', true)->sum(DB::raw('precio_costo * stock'));
        $totalInventoryPrice = Product::where('active', true)->sum(DB::raw('precio_venta * stock'));
        $lowStockCount = Product::whereRaw('stock <= stock_minimo')->where('active', true)->count();

        return response()->streamDownload(function () use ($products, $productsWithVariants, $totalInventoryCost, $totalInventoryPrice, $lowStockCount) {
            echo '<!DOCTYPE html>
            <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <style>
                    table { border-collapse: collapse; width: 100%; }
                    th, td { border: 1px solid #000000; padding: 5px; text-align: left; }
                    th { background-color: #f2f2f2; font-weight: bold; }
                    .header { text-align: center; font-size: 14px; margin-bottom: 20px; font-weight: bold; }
                </style>
            </head>
            <body>
                <div class="header">Reporte de Control de Stock - ' . date('d/m/Y') . '</div>
                
                <h3>Resumen</h3>
                <table>
                    <tr>
                        <th>Valor Total (Costo)</th>
                        <th>Valor Total (Venta)</th>
                        <th>Productos Bajo Stock</th>
                    </tr>
                    <tr>
                        <td>Q ' . number_format($totalInventoryCost, 2) . '</td>
                        <td>Q ' . number_format($totalInventoryPrice, 2) . '</td>
                        <td style="color:' . ($lowStockCount > 0 ? 'red' : 'black') . ';">' . $lowStockCount . '</td>
                    </tr>
                </table>

                <h3>Detalle de Inventario</h3>
                <table>
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Producto</th>
                            <th>Costo</th>
                            <th>Venta</th>
                            <th>Stock</th>
                            <th>Mínimo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($products as $product) {
                $stockStyle = $product->stock <= $product->stock_minimo ? 'color: red; font-weight: bold;' : '';
                echo '<tr>
                    <td>' . $product->sku . '</td>
                    <td>' . $product->name . '</td>
                    <td>' . $product->precio_costo . '</td>
                    <td>' . $product->precio_venta . '</td>
                    <td style="' . $stockStyle . '">' . $product->stock . '</td>
                    <td>' . $product->stock_minimo . '</td>
                    <td>' . ($product->active ? 'Activo' : 'Inactivo') . '</td>
                </tr>';
            }

            echo '</tbody>
                </table>
            </body>
            </html>';
        }, 'control-stock-' . date('Y-m-d') . '.xls');
    }

    public function exportPdf()
    {
        $products = Product::where('active', true)->get();
        $productsWithVariants = Product::where('stock_por_variante', true)
            ->where('active', true)
            ->with(['variants' => function ($query) {
                $query->orderBy('type')->orderBy('value');
            }])
            ->get();

        $totalInventoryCost = Product::where('active', true)->sum(DB::raw('precio_costo * stock'));
        $totalInventoryPrice = Product::where('active', true)->sum(DB::raw('precio_venta * stock'));
        $lowStockCount = Product::whereRaw('stock <= stock_minimo')->where('active', true)->count();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.stock-control.pdf', [
            'products' => $products,
            'productsWithVariants' => $productsWithVariants,
            'totalInventoryCost' => $totalInventoryCost,
            'totalInventoryPrice' => $totalInventoryPrice,
            'lowStockCount' => $lowStockCount
        ]);

        $pdf->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'control-stock-' . date('Y-m-d') . '.pdf');
    }

    public function anularMovimiento($id)
    {
        try {
            DB::beginTransaction();

            $movement = StockMovement::findOrFail($id);
            $product = $movement->product;

            // Crear movimiento inverso
            $nuevoStock = $product->stock - $movement->quantity;

            StockMovement::create([
                'product_id' => $movement->product_id,
                'type' => 'ajuste',
                'quantity' => -$movement->quantity,
                'stock_antes' => $product->stock,
                'stock_despues' => $nuevoStock,
                'motivo' => 'Anulación de movimiento #' . $movement->id,
                'notas' => 'Movimiento original: ' . $movement->motivo,
                'user_id' => Auth::id(),
            ]);

            // Actualizar stock del producto
            $product->update(['stock' => $nuevoStock]);

            DB::commit();

            session()->flash('message', 'Movimiento anulado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al anular movimiento: ' . $e->getMessage());
        }
    }
}
