<?php

namespace App\Livewire\Admin\StockControl;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockMovement;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $product_id = '';
    public $variant_id = '';
    public $type = 'entrada';
    public $quantity = '';
    public $motivo = '';
    public $notas = '';
    public $searchProduct = '';
    public $filteredProducts;
    public $selectedProduct = null;
    public $productVariants = [];

    protected $rules = [
        'product_id' => 'required|exists:products,id',
        'variant_id' => 'nullable|exists:product_variants,id',
        'type' => 'required|in:entrada,salida,ajuste,devolucion',
        'quantity' => 'required|integer|min:1',
        'motivo' => 'required|string|max:255',
        'notas' => 'nullable|string',
    ];

    public function mount()
    {
        $this->filteredProducts = collect();
    }

    public function updatedSearchProduct()
    {
        if ($this->searchProduct) {
            $this->filteredProducts = Product::with('variants')
                ->where('active', true)
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->searchProduct . '%')
                          ->orWhere('sku', 'like', '%' . $this->searchProduct . '%');
                })
                ->limit(10)
                ->get();
        } else {
            $this->filteredProducts = collect();
        }
    }

    public function selectProduct($productId)
    {
        $this->product_id = $productId;
        $this->selectedProduct = Product::with('variants')->find($productId);
        $this->productVariants = $this->selectedProduct->variants ?? collect();
        $this->variant_id = '';
        $this->searchProduct = '';
        $this->filteredProducts = collect();
    }

    public function clearProduct()
    {
        $this->product_id = '';
        $this->selectedProduct = null;
        $this->productVariants = [];
        $this->variant_id = '';
    }

    public function save()
    {
        $this->validate();

        $product = Product::with('variants')->findOrFail($this->product_id);
        
        // Si el producto maneja stock por variante y se seleccionó una variante
        if ($product->stock_por_variante && $this->variant_id) {
            $variant = ProductVariant::findOrFail($this->variant_id);
            $stockAntes = $variant->stock;

            if ($this->type === 'entrada' || $this->type === 'devolucion') {
                $stockDespues = $stockAntes + $this->quantity;
            } else {
                $stockDespues = $stockAntes - $this->quantity;
            }

            if ($stockDespues < 0) {
                $this->addError('quantity', 'No hay suficiente stock disponible para esta variante');
                return;
            }

            // Actualizar stock de la variante
            $variant->update(['stock' => $stockDespues]);

            // Recalcular stock total del producto
            $product->stock = $product->variants()->sum('stock');
            $product->save();

            // Motivo con variante
            $variantText = $variant->type . ': ' . $variant->value;
            $motivoCompleto = $this->motivo . ' (' . $variantText . ')';

            StockMovement::create([
                'product_id' => $this->product_id,
                'type' => $this->type,
                'quantity' => $this->type === 'salida' ? -$this->quantity : $this->quantity,
                'stock_antes' => $stockAntes,
                'stock_despues' => $stockDespues,
                'motivo' => $motivoCompleto,
                'notas' => $this->notas,
                'user_id' => Auth::id(),
            ]);

        } else {
            // Stock normal del producto (sin variantes)
            $stockAntes = $product->stock;

            if ($this->type === 'entrada' || $this->type === 'devolucion') {
                $stockDespues = $stockAntes + $this->quantity;
            } else {
                $stockDespues = $stockAntes - $this->quantity;
            }

            if ($stockDespues < 0) {
                $this->addError('quantity', 'No hay suficiente stock disponible');
                return;
            }

            StockMovement::create([
                'product_id' => $this->product_id,
                'type' => $this->type,
                'quantity' => $this->type === 'salida' ? -$this->quantity : $this->quantity,
                'stock_antes' => $stockAntes,
                'stock_despues' => $stockDespues,
                'motivo' => $this->motivo,
                'notas' => $this->notas,
                'user_id' => Auth::id(),
            ]);

            $product->update(['stock' => $stockDespues]);
        }

        session()->flash('message', 'Movimiento registrado correctamente');
        return redirect()->route('admin.stock-control.index');
    }

    public function render()
    {
        $products = Product::with('variants')
            ->where('active', true)
            ->orderBy('name')
            ->get();

        return view('livewire.admin.stock-control.create', [
            'products' => $products
        ]);
    }
}