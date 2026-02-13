<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = [
        'sale_id',
        'serie',
        'numero',
        'uuid',
        'nit',
        'nombre',
        'direccion',
        'subtotal',
        'iva',
        'total',
        'fecha_emision',
        'fecha_certificacion',
        'xml_fel',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'iva' => 'decimal:2',
        'total' => 'decimal:2',
        'fecha_emision' => 'datetime',
        'fecha_certificacion' => 'datetime',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    // Helper para generar número de factura completo
    public function getNumeroCompleto(): string
    {
        return $this->serie . '-' . $this->numero;
    }
}