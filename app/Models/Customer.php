<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'nit',
        'email',
        'telefono',
        'direccion',
        'tipo',
        'descuento_porcentaje',
        'limite_credito',
        'total_gastado',
        'activo',
    ];

    protected $casts = [
        'descuento_porcentaje' => 'decimal:2',
        'limite_credito' => 'decimal:2',
        'total_gastado' => 'decimal:2',
        'activo' => 'boolean',
    ];

    // RELACIONES
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    // HELPERS
    public function hasUser()
    {
        return !is_null($this->user_id);
    }

    public function isEmpresa()
    {
        return $this->tipo === 'empresa';
    }

    public function initials(): string
    {
        $names = explode(' ', $this->nombre);
        
        if (count($names) >= 2) {
            return strtoupper(substr($names[0], 0, 1) . substr($names[1], 0, 1));
        }
        
        return strtoupper(substr($this->nombre, 0, 2));
    }
}