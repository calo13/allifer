<?php

namespace App\Livewire\Admin\StockControl;

use App\Models\Product;
use App\Models\StockMovement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class ProductHistory extends Component
{
    use WithPagination;

    public $product;
    public $filterType = '';
    public $filterDate = '';
    protected $listeners = ['anular-movimiento' => 'anularMovimiento'];

    public function mount($productId)
    {
        $this->product = Product::findOrFail($productId);
    }

    public function render()
    {
        $movements = StockMovement::where('product_id', $this->product->id)
            ->when($this->filterType, function($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterDate, function($query) {
                $query->whereDate('created_at', $this->filterDate);
            })
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('livewire.admin.stock-control.product-history', [
            'movements' => $movements
        ]);
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
        session()->flash('error', 'Error al anular: ' . $e->getMessage());
    }
}
}