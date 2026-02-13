<?php

namespace App\Livewire\Admin\Suppliers;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    
    public $showModal = false;
    public $editMode = false;
    public $supplierId = null;
    
    public $name = '';
    public $nit = '';
    public $phone = '';
    public $email = '';
    public $address = '';
    public $active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'nit' => 'nullable|string|max:20',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string',
        'active' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'email.email' => 'El email debe ser válido.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['name', 'nit', 'phone', 'email', 'address', 'supplierId', 'editMode']);
        $this->active = true;
        $this->showModal = true;
        $this->resetValidation();
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        
        $this->supplierId = $supplier->id;
        $this->name = $supplier->name;
        $this->nit = $supplier->nit;
        $this->phone = $supplier->phone;
        $this->email = $supplier->email;
        $this->address = $supplier->address;
        $this->active = $supplier->active;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
        $this->reset(['name', 'nit', 'phone', 'email', 'address', 'supplierId', 'editMode']);
        $this->active = true;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $supplier = Supplier::findOrFail($this->supplierId);
            $supplier->update([
                'name' => $this->name,
                'nit' => $this->nit,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'active' => $this->active,
            ]);

            $this->dispatch('supplier-saved', [
                'message' => "El proveedor '{$supplier->name}' ha sido actualizado."
            ]);
        } else {
            $supplier = Supplier::create([
                'name' => $this->name,
                'nit' => $this->nit,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'active' => $this->active,
            ]);

            $this->dispatch('supplier-saved', [
                'message' => "El proveedor '{$supplier->name}' ha sido creado."
            ]);
        }

        $this->close();
    }

    public function delete($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplierName = $supplier->name;
        
        $hasProducts = $supplier->products()->exists();
        
        if ($hasProducts) {
            $supplier->active = false;
            $supplier->save();
            
            $this->dispatch('supplier-deactivated', [
                'message' => "'{$supplierName}' tiene productos. Se ha desactivado."
            ]);
        } else {
            $supplier->delete();
            
            $this->dispatch('supplier-deleted', [
                'message' => "'{$supplierName}' ha sido eliminado."
            ]);
        }
    }

    public function toggleActive($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->active = !$supplier->active;
        $supplier->save();
        
        $event = $supplier->active ? 'supplier-saved' : 'supplier-deactivated';
        $message = $supplier->active ? "'{$supplier->name}' activado." : "'{$supplier->name}' desactivado.";
        
        $this->dispatch($event, ['message' => $message]);
    }

    public function render()
    {
        $suppliers = Supplier::query()
            ->withCount('products')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('nit', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.suppliers.index', [
            'suppliers' => $suppliers,
        ]);
    }
}