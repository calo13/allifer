<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'product_variant_id',
        'product_name',
        'variants',
        'variant_text',
        'quantity',
        'precio_unitario',
        'precio_costo',
        'subtotal',
        'descuento',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'precio_costo' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'variants' => 'array',
    ];

    // RELACIONES
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
