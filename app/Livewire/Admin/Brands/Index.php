<?php

namespace App\Livewire\Admin\Brands;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    
    public $showModal = false;
    public $editMode = false;
    public $brandId = null;
    
    public $name = '';
    public $description = '';
    public $active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'active' => 'boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['name', 'description', 'brandId', 'editMode']);
        $this->active = true;
        $this->showModal = true;
        $this->resetValidation();
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        
        $this->brandId = $brand->id;
        $this->name = $brand->name;
        $this->description = $brand->description;
        $this->active = $brand->active;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
        $this->reset(['name', 'description', 'brandId', 'editMode']);
        $this->active = true;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $brand = Brand::findOrFail($this->brandId);
            $brand->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'active' => $this->active,
            ]);

            $this->dispatch('brand-saved', [
                'message' => "La marca '{$brand->name}' ha sido actualizada."
            ]);
        } else {
            $brand = Brand::create([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'active' => $this->active,
            ]);

            $this->dispatch('brand-saved', [
                'message' => "La marca '{$brand->name}' ha sido creada."
            ]);
        }

        $this->close();
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);
        $brandName = $brand->name;
        
        $hasProducts = $brand->products()->exists();
        
        if ($hasProducts) {
            $brand->active = false;
            $brand->save();
            
            $this->dispatch('brand-deactivated', [
                'message' => "'{$brandName}' tiene productos. Se ha desactivado."
            ]);
        } else {
            $brand->delete();
            
            $this->dispatch('brand-deleted', [
                'message' => "'{$brandName}' ha sido eliminada."
            ]);
        }
    }

    public function toggleActive($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->active = !$brand->active;
        $brand->save();
        
        $event = $brand->active ? 'brand-saved' : 'brand-deactivated';
        $message = $brand->active ? "'{$brand->name}' activada." : "'{$brand->name}' desactivada.";
        
        $this->dispatch($event, ['message' => $message]);
    }

    public function render()
    {
        $brands = Brand::query()
            ->withCount('products')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.brands.index', [
            'brands' => $brands,
        ]);
    }
}