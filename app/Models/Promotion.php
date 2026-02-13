<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promotion extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'descuento_porcentaje',
        'descuento_monto',
        'aplica_online',
        'aplica_tienda',
        'fecha_inicio',
        'fecha_fin',
        'dias_semana',
        'active',
    ];

    protected $casts = [
        'descuento_porcentaje' => 'decimal:2',
        'descuento_monto' => 'decimal:2',
        'aplica_online' => 'boolean',
        'aplica_tienda' => 'boolean',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'dias_semana' => 'array',
        'active' => 'boolean',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'promotion_products');
    }

    public function scopeActive($query)
    {
        $now = now();
        return $query->where('active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('fecha_inicio')->orWhere('fecha_inicio', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('fecha_fin')->orWhere('fecha_fin', '>=', $now);
            });
    }

    public function isActive(): bool
    {
        $now = now();
        $start = $this->fecha_inicio ?? $now->copy()->subMinute(); // Si es null, asume que ya empezó
        $end = $this->fecha_fin ?? $now->copy()->addMinute();      // Si es null, asume que aún no termina

        return $this->active && $now->between($start, $end);
    }
}
