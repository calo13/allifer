<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'sale_id',
        'metodo',
        'monto',
        'referencia',
        'estado',
        'notas',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    // Helper para verificar si está aprobado
    public function isApproved(): bool
    {
        return $this->estado === 'aprobado';
    }
}