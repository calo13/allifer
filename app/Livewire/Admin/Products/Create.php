<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Create extends Component
{
    use WithFileUploads;

    // Campos del formulario
    public $sku = '';
    public $barcode = '';
    public $name = '';
    public $description = '';
    public $precio_costo = '';
    public $precio_venta = '';
    public $precio_mayorista = null;
    public $stock = '';
    public $stock_minimo = 5;
    public $category_id = '';
    public $brand_id = '';
    public $supplier_id = '';
    public $image;
    public $additionalImages = [];
    public $active = true;
    public $featured = false;

    // Variantes
    public $variants = [];
    public $newVariantType = '';
    public $newVariantValue = '';
    public $newVariantPrice = 0;
    public $newVariantStock = 0;
    
    // Control de stock por variante
    public $stockPorVariante = false;

    protected function rules()
    {
        $rules = [
            'sku' => 'nullable|string|unique:products,sku',
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

    public function save()
    {
        $this->validate();

        $product = new Product();
        $product->sku = $this->sku ?: null;
        $product->barcode = $this->barcode;
        $product->name = $this->name;
        $product->slug = Str::slug($this->name);
        $product->description = $this->description;
        
        // Convertir valores vacíos a 0
        $product->precio_costo = $this->precio_costo !== '' ? $this->precio_costo : 0;
        $product->precio_venta = $this->precio_venta !== '' ? $this->precio_venta : 0;
        $product->precio_mayorista = $this->precio_mayorista !== '' ? $this->precio_mayorista : null;
        $product->stock_minimo = $this->stock_minimo !== '' ? $this->stock_minimo : 5;
        
        // Guardar el modo de stock
        $product->stock_por_variante = $this->stockPorVariante;
        
        // Calcular stock según el modo
        if ($this->stockPorVariante && count($this->variants) > 0) {
            // Stock es la suma de todas las variantes
            $product->stock = collect($this->variants)->sum('stock');
        } else {
            $product->stock = $this->stock !== '' ? $this->stock : 0;
        }
        
        $product->category_id = $this->category_id ?: null;
        $product->brand_id = $this->brand_id ?: null;
        $product->supplier_id = $this->supplier_id ?: null;
        $product->active = $this->active;
        $product->featured = $this->featured;

        // Guardar imagen
        if ($this->image) {
            $product->image = $this->image->store('products', 'public');
        }

        $product->save();
        
        // Guardar imágenes adicionales
        if ($this->additionalImages && count($this->additionalImages) > 0) {
            foreach ($this->additionalImages as $index => $img) {
                $product->images()->create([
                    'image_path' => $img->store('products', 'public'),
                    'order' => $index,
                ]);
            }
        }
        
        // Guardar variantes
        foreach ($this->variants as $variant) {
            $product->variants()->create([
                'type' => $variant['type'],
                'value' => $variant['value'],
                'precio_adicional' => $variant['precio_adicional'] ?? 0,
                'stock' => $variant['stock'] ?? 0,
            ]);
        }

        // Dispatch evento para SweetAlert2
        $this->dispatch('product-created', [
            'message' => "El producto '{$product->name}' ha sido creado correctamente."
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
    
    public function removeAdditionalImage($index)
    {
        $images = collect($this->additionalImages)->values()->toArray();
        unset($images[$index]);
        $this->additionalImages = array_values($images);
    }

    public function render()
    {
        return view('livewire.admin.products.create', [
            'categories' => Category::where('active', true)->orderBy('name')->get(),
            'brands' => Brand::where('active', true)->orderBy('name')->get(),
            'suppliers' => Supplier::where('active', true)->orderBy('name')->get(),
        ]);
    }
}