<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Product;

class ProductDetail extends Component
{
    public Product $product;
    public $selectedImage = 0;
    public $selectedVariants = [];
    public $quantity = 1;

    public function mount(Product $product)
    {
        $this->product = $product->load(['category', 'brand', 'images', 'variants']);
    }

    public function selectImage($index)
    {
        $this->selectedImage = $index;
    }

    public function incrementQuantity()
    {
        if ($this->quantity < $this->availableStock) {
            $this->quantity++;
        }
    }

    public function addToCart()
    {
        $this->dispatch('add-to-cart', [
            'productId' => $this->product->id,
            'quantity' => $this->quantity,
            'variants' => $this->selectedVariants,
            'finalPrice' => $this->finalPrice
        ]);

        // Resetear cantidad
        $this->quantity = 1;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function render()
    {
        $relatedProducts = Product::where('active', true)
            ->where('stock', '>', 0)
            ->where('category_id', $this->product->category_id)
            ->where('id', '!=', $this->product->id)
            ->limit(4)
            ->get();
        return view('livewire.shop.product-detail', [
            'relatedProducts' => $relatedProducts
        ]);
    }

    // Agregar esta propiedad computed para el precio final
    public function getFinalPriceProperty()
    {
        $price = $this->product->has_discount ? $this->product->discount_price : $this->product->precio_venta;

        foreach ($this->selectedVariants as $type => $value) {
            $variant = $this->product->variants
                ->where('type', $type)
                ->where('value', $value)
                ->first();

            if ($variant && $variant->precio_adicional > 0) {
                $price += $variant->precio_adicional;
            }
        }

        return $price;
    }

    // Agregar método para obtener el stock disponible según variante
    public function getAvailableStockProperty()
    {
        // Si el producto maneja stock por variante
        if ($this->product->stock_por_variante && count($this->selectedVariants) > 0) {
            // Buscar la variante seleccionada y retornar su stock
            foreach ($this->selectedVariants as $type => $value) {
                $variant = $this->product->variants
                    ->where('type', $type)
                    ->where('value', $value)
                    ->first();

                if ($variant) {
                    return $variant->stock;
                }
            }
        }

        // Si no, retornar stock general del producto
        return $this->product->stock;
    }
}
