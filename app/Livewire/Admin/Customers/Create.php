<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Livewire\Component;

class Create extends Component
{
    public $nombre = '';
    public $nit = 'CF';
    public $email = '';
    public $telefono = '';
    public $direccion = '';
    public $tipo = 'consumidor_final';
    public $descuento_porcentaje = 0;
    public $limite_credito = 0;
    public $activo = true;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'nit' => 'required|string|max:255',
        'email' => 'nullable|email|unique:customers,email',
        'telefono' => 'nullable|string|max:20',
        'direccion' => 'nullable|string',
        'tipo' => 'required|in:consumidor_final,empresa',
        'descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
        'limite_credito' => 'nullable|numeric|min:0',
        'activo' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        Customer::create([
            'nombre' => $this->nombre,
            'nit' => $this->nit,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'tipo' => $this->tipo,
            'descuento_porcentaje' => $this->descuento_porcentaje ?? 0,
            'limite_credito' => $this->limite_credito ?? 0,
            'activo' => $this->activo,
        ]);

        session()->flash('message', 'Cliente creado correctamente');
        return redirect()->route('admin.customers.index');
    }

    public function render()
    {
        return view('livewire.admin.customers.create');
    }
}