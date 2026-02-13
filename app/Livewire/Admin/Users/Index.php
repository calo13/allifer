<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterRole = '';
    public $filterActive = '';

    protected $queryString = ['search', 'filterRole', 'filterActive'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleActive($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['active' => !$user->active]);
        
        session()->flash('message', $user->active ? 'Usuario activado' : 'Usuario desactivado');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterRole, function ($query) {
                $query->role($this->filterRole);
            })
            ->when($this->filterActive !== '', function ($query) {
                $query->where('active', $this->filterActive);
            })
            ->latest()
            ->paginate(15);

        $roles = Role::all();

        return view('livewire.admin.users.index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}