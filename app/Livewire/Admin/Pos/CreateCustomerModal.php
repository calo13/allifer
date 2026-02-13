<?php

namespace App\Livewire\Admin\Pos;

use App\Models\Customer;
use Livewire\Component;

class CreateCustomerModal extends Component
{
    public $showModal = false;
    public $nit = '';
    public $nombre = '';
    public $email = '';
    public $telefono = '';

    protected $listeners = ['openCreateCustomerModal'];

    protected $rules = [
        'nit' => 'required|string|max:20|unique:customers,nit',
        'nombre' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'telefono' => 'nullable|string|max:20',
    ];

    public function openCreateCustomerModal($nit)
    {
        //  dd('Modal abierto con NIT: ' . $nit);
        $this->reset(['nombre', 'email', 'telefono']);
        $this->nit = $nit;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $customer = Customer::create([
            'nit' => $this->nit,
            'nombre' => $this->nombre,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'activo' => true,
        ]);

        $this->showModal = false;

        // Emitir evento para seleccionar el cliente recién creado
        $this->dispatch('customerCreated', customerId: $customer->id);

        session()->flash('message', 'Cliente creado exitosamente');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['nit', 'nombre', 'email', 'telefono']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.pos.create-customer-modal');
    }
}