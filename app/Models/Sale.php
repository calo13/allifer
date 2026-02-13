<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio',
        'tipo_venta',
        'tipo_documento',
        'customer_id',
        'nit_cliente',
        'nombre_cliente',
        'subtotal',
        'iva',
        'descuento',
        'total',
        'metodo_pago',
        'estado',
        'user_id',
        'cash_register_id',
        'fecha_venta',
    ];

    protected $casts = [
        'fecha_venta' => 'datetime',
        'subtotal' => 'decimal:2',
        'iva' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // RELACIONES
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // HELPERS
    public function isTipoFactura()
    {
        return $this->tipo_documento === 'factura';
    }
}