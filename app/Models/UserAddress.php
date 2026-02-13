<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'alias',
        'direccion',
        'zona',
        'municipio',
        'departamento',
        'referencia',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Obtener dirección completa formateada
    public function getFullAddressAttribute(): string
    {
        $parts = [$this->direccion];

        if ($this->zona) {
            $parts[] = 'Zona ' . $this->zona;
        }
        if ($this->municipio) {
            $parts[] = $this->municipio;
        }
        if ($this->departamento && $this->departamento !== 'Guatemala') {
            $parts[] = $this->departamento;
        }

        return implode(', ', $parts);
    }
}
