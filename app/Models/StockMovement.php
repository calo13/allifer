<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    protected $fillable = [
        'product_id',
        'product_variant_id',
        'type',
        'quantity',
        'stock_antes',
        'stock_despues',
        'motivo',
        'notas',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relaciones
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeEntradas($query)
    {
        return $query->where('type', 'entrada');
    }

    public function scopeSalidas($query)
    {
        return $query->where('type', 'salida');
    }

    public function scopeAjustes($query)
    {
        return $query->where('type', 'ajuste');
    }

    public function scopeDevoluciones($query)
    {
        return $query->where('type', 'devolucion');
    }
}
