<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Edit extends Component
{
    use WithFileUploads;

    public Product $product;

    // Campos del formulario
    public $sku;
    public $barcode;
    public $name;
    public $description;
    public $precio_costo;
    public $precio_venta;
    public $precio_mayorista;
    public $stock;
    public $stock_minimo;
    public $category_id;
    public $brand_id;
    public $supplier_id;
    public $image;
    public $active;
    public $featured;
    
    // Imágenes adicionales
    public $additionalImages = [];
    public $existingImages = [];

    // Variantes
    public $variants = [];
    public $newVariantType = '';
    public $newVariantValue = '';
    public $newVariantPrice = 0;
    public $newVariantStock = 0;
    
    // Control de stock por variante
    public $stockPorVariante = false;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->sku = $product->sku;
        $this->barcode = $product->barcode;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->precio_costo = $product->precio_costo;
        $this->precio_venta = $product->precio_venta;
        $this->precio_mayorista = $product->precio_mayorista;
        $this->stock = $product->stock;
        $this->stock_minimo = $product->stock_minimo;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->supplier_id = $product->supplier_id;
        $this->active = $product->active;
        $this->featured = $product->featured;
        
        // Cargar imágenes existentes
        $this->existingImages = $product->images->toArray();

        // Cargar variantes existentes
        $this->variants = $product->variants->toArray();
        
        // Determinar si el stock se maneja por variante
        // Si hay variantes con stock > 0, asumimos que es stock por variante
        $this->stockPorVariante = $product->stock_por_variante ?? 
            (count($this->variants) > 0 && collect($this->variants)->sum('stock') > 0);
    }

    protected function rules()
    {
        $rules = [
            'sku' => 'nullable|string|unique:products,sku,' . $this->product->id,
            'name' => 'required|string|max:255',
            'precio_venta' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'image' => 'nullable|image|max:2048',
            'additionalImages.*' => 'nullable|image|max:2048',
        ];
        
        // Stock solo es requerido si NO es por variante
        if (!$this->stockPorVariante) {
            $rules['stock'] = 'required|integer|min:0';
        }
        
        return $rules;
    }

    protected $messages = [
        'name.required' => 'El nombre del producto es obligatorio.',
        'precio_venta.required' => 'El precio de venta es obligatorio.',
        'precio_venta.numeric' => 'El precio debe ser un número válido.',
        'precio_venta.min' => 'El precio debe ser mayor o igual a 0.',
        'stock.required' => 'El stock es obligatorio.',
        'stock.integer' => 'El stock debe ser un número entero.',
        'stock.min' => 'El stock no puede ser negativo.',
        'image.image' => 'El archivo debe ser una imagen.',
        'image.max' => 'La imagen no puede pesar más de 2MB.',
    ];

    public function update()
    {
        $this->validate();

        $this->product->sku = $this->sku ?: null;
        $this->product->barcode = $this->barcode;
        $this->product->name = $this->name;
        $this->product->slug = Str::slug($this->name);
        $this->product->description = $this->description;
        $this->product->precio_costo = $this->precio_costo;
        $this->product->precio_venta = $this->precio_venta;
        $this->product->precio_mayorista = $this->precio_mayorista;
        $this->product->stock_minimo = $this->stock_minimo;
        $this->product->category_id = $this->category_id ?: null;
        $this->product->brand_id = $this->brand_id ?: null;
        $this->product->supplier_id = $this->supplier_id ?: null;
        $this->product->active = $this->active;
        $this->product->featured = $this->featured;
        
        // Guardar el modo de stock
        $this->product->stock_por_variante = $this->stockPorVariante;
        
        // Calcular stock según el modo
        if ($this->stockPorVariante && count($this->variants) > 0) {
            // Stock es la suma de todas las variantes
            $this->product->stock = collect($this->variants)->sum('stock');
        } else {
            $this->product->stock = $this->stock;
        }

        // Guardar nueva imagen
        if ($this->image) {
            // Eliminar imagen anterior
            if ($this->product->image && \Storage::exists('public/' . $this->product->image)) {
                \Storage::delete('public/' . $this->product->image);
            }
            $this->product->image = $this->image->store('products', 'public');
        }
        
        // Guardar imágenes adicionales
        if ($this->additionalImages) {
            foreach ($this->additionalImages as $index => $img) {
                $this->product->images()->create([
                    'image_path' => $img->store('products', 'public'),
                    'order' => $index,
                ]);
            }
        }

        // Guardar variantes
        $this->product->variants()->delete();
        foreach ($this->variants as $variant) {
            $this->product->variants()->create([
                'type' => $variant['type'],
                'value' => $variant['value'],
                'precio_adicional' => $variant['precio_adicional'] ?? 0,
                'stock' => $variant['stock'] ?? 0,
            ]);
        }
        
        $this->product->save();

        // Dispatch evento para SweetAlert2
        $this->dispatch('product-updated', [
            'message' => "El producto '{$this->product->name}' ha sido actualizado correctamente."
        ]);

        return redirect()->route('admin.products.index');
    }
    
    public function addVariant()
    {
        if (empty($this->newVariantType) || empty($this->newVariantValue)) {
            return;
        }

        $this->variants[] = [
            'id' => null,
            'type' => $this->newVariantType,
            'value' => $this->newVariantValue,
            'precio_adicional' => $this->newVariantPrice ?? 0,
            'stock' => $this->newVariantStock ?? 0,
        ];

        // Limpiar formulario
        $this->newVariantType = '';
        $this->newVariantValue = '';
        $this->newVariantPrice = 0;
        $this->newVariantStock = 0;
    }

    public function removeVariant($index)
    {
        unset($this->variants[$index]);
        $this->variants = array_values($this->variants);
    }

    public function removeExistingImage($imageId)
    {
        $image = ProductImage::find($imageId);
        if ($image) {
            // Eliminar archivo físico
            if (\Storage::exists('public/' . $image->image_path)) {
                \Storage::delete('public/' . $image->image_path);
            }
            $image->delete();
        }
        $this->existingImages = collect($this->existingImages)->where('id', '!=', $imageId)->values()->toArray();
    }
    
    public function render()
    {
        return view('livewire.admin.products.edit', [
            'categories' => Category::where('active', true)->orderBy('name')->get(),
            'brands' => Brand::where('active', true)->orderBy('name')->get(),
            'suppliers' => Supplier::where('active', true)->orderBy('name')->get(),
        ]);
    }
}
