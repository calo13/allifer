<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'value',
        'precio_adicional',
        'stock',
        'sku',
    ];

    protected $casts = [
        'precio_adicional' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Helper para obtener precio total de la variante
    public function getPrecioTotal()
    {
        return $this->product->precio_venta + $this->precio_adicional;
    }

    public function hayStock(): bool
    {
        return $this->stock > 0;
    }
}