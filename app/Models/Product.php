<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'sku',
        'barcode',
        'name',
        'slug',
        'description',
        'precio_costo',
        'precio_venta',
        'precio_mayorista',
        'stock',
        'stock_minimo',
        'category_id',
        'brand_id',
        'supplier_id',
        'image',
        'active',
        'featured',
    ];

    protected $casts = [
        'precio_costo' => 'decimal:2',
        'precio_venta' => 'decimal:2',
        'precio_mayorista' => 'decimal:2',
        'active' => 'boolean',
        'featured' => 'boolean',
    ];

    // Auto-generar SKU si está vacío
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->sku)) {
                // Genera SKU automático: PROD-00001
                $lastProduct = Product::orderBy('id', 'desc')->first();
                $nextId = $lastProduct ? $lastProduct->id + 1 : 1;
                $product->sku = 'PROD-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    // RELACIONES
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'promotion_products');
    }

    // HELPERS
    public function getPrecioConIva()
    {
        // En Guatemala el IVA (12%) ya está incluido en el precio
        // Si necesitas calcular el IVA desde el precio:
        $subtotal = $this->precio_venta / 1.12;
        $iva = $this->precio_venta - $subtotal;

        return [
            'precio_con_iva' => $this->precio_venta,
            'subtotal' => round($subtotal, 2),
            'iva' => round($iva, 2),
        ];
    }

    public function hayStock(): bool
    {
        return $this->stock > 0;
    }

    // PRODUCT DISCOUNT LOGIC
    public function getActiveDiscountAttribute()
    {
        // Obtener la mejor promoción activa para este producto
        // Se prioriza la que de el precio más bajo (mayor descuento)
        return $this->promotions()
            ->active()
            ->get()
            ->sortByDesc(function ($promo) {
                if ($promo->type === 'porcentaje') {
                    return $this->precio_venta * ($promo->descuento_porcentaje / 100);
                } elseif ($promo->type === 'monto_fijo') {
                    return $promo->descuento_monto;
                }
                return 0;
            })
            ->first();
    }

    public function getDiscountPriceAttribute()
    {
        $promo = $this->active_discount;

        if (!$promo) {
            return $this->precio_venta;
        }

        if ($promo->type === 'porcentaje') {
            return round($this->precio_venta * (1 - ($promo->descuento_porcentaje / 100)), 2);
        } elseif ($promo->type === 'monto_fijo') {
            return max(0, $this->precio_venta - $promo->descuento_monto);
        }

        return $this->precio_venta;
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->active_discount !== null;
    }

    public function getDiscountPercentageAttribute()
    {
        $promo = $this->active_discount;
        if (!$promo) return 0;

        if ($promo->type === 'porcentaje') {
            return round($promo->descuento_porcentaje);
        } elseif ($promo->type === 'monto_fijo') {
            if ($this->precio_venta > 0) {
                return round(($promo->descuento_monto / $this->precio_venta) * 100);
            }
        }
        return 0;
    }

    public function stockBajo(): bool
    {
        return $this->stock <= $this->stock_minimo;
    }
}
