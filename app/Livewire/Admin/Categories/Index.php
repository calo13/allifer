<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
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
    public $categoryId = null;
    
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
        $this->reset(['name', 'description', 'categoryId', 'editMode']);
        $this->active = true;
        $this->showModal = true;
        $this->resetValidation();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->active = $category->active;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
        $this->reset(['name', 'description', 'categoryId', 'editMode']);
        $this->active = true;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $category = Category::findOrFail($this->categoryId);
            $category->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'active' => $this->active,
            ]);

            $this->dispatch('category-saved', [
                'message' => "La categoría '{$category->name}' ha sido actualizada."
            ]);
        } else {
            $category = Category::create([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'active' => $this->active,
            ]);

            $this->dispatch('category-saved', [
                'message' => "La categoría '{$category->name}' ha sido creada."
            ]);
        }

        $this->close();
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $categoryName = $category->name;
        
        $hasProducts = $category->products()->exists();
        
        if ($hasProducts) {
            $category->active = false;
            $category->save();
            
            $this->dispatch('category-deactivated', [
                'message' => "'{$categoryName}' tiene productos. Se ha desactivado."
            ]);
        } else {
            $category->delete();
            
            $this->dispatch('category-deleted', [
                'message' => "'{$categoryName}' ha sido eliminada."
            ]);
        }
    }

    public function toggleActive($id)
    {
        $category = Category::findOrFail($id);
        $category->active = !$category->active;
        $category->save();
        
        $event = $category->active ? 'category-saved' : 'category-deactivated';
        $message = $category->active ? "'{$category->name}' activada." : "'{$category->name}' desactivada.";
        
        $this->dispatch($event, ['message' => $message]);
    }

    public function render()
    {
        $categories = Category::query()
            ->withCount('products')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.categories.index', [
            'categories' => $categories,
        ]);
    }
}