<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Livewire\Component;

class Edit extends Component
{
    public Customer $customer;
    public $nombre;
    public $nit;
    public $email;
    public $telefono;
    public $direccion;
    public $tipo;
    public $descuento_porcentaje;
    public $limite_credito;
    public $activo;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'nit' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $this->customer->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'tipo' => 'required|in:consumidor_final,empresa',
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
            'limite_credito' => 'nullable|numeric|min:0',
            'activo' => 'boolean',
        ];
    }

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
        $this->nombre = $customer->nombre;
        $this->nit = $customer->nit;
        $this->email = $customer->email;
        $this->telefono = $customer->telefono;
        $this->direccion = $customer->direccion;
        $this->tipo = $customer->tipo;
        $this->descuento_porcentaje = $customer->descuento_porcentaje;
        $this->limite_credito = $customer->limite_credito;
        $this->activo = $customer->activo;
    }

    public function update()
    {
        $this->validate();

        $this->customer->update([
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

        session()->flash('message', 'Cliente actualizado correctamente');
        return redirect()->route('admin.customers.index');
    }

    public function render()
    {
        return view('livewire.admin.customers.edit');
    }
}