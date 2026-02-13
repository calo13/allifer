<?php

namespace App\Livewire\Admin\Promotions;

use App\Models\Promotion;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleActive($id)
    {
        $promotion = Promotion::find($id);
        if ($promotion) {
            $promotion->active = !$promotion->active;
            $promotion->save();
        }
    }

    public function delete($id)
    {
        $promotion = Promotion::find($id);
        if ($promotion) {
            $promotion->delete();
        }
    }

    public function render()
    {
        $promotions = Promotion::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.promotions.index', [
            'promotions' => $promotions
        ]);
    }
}
