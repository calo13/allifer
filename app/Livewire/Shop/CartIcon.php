<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use Livewire\Attributes\On;

class CartIcon extends Component
{
    public $cartCount = 0;

    #[On('cart-updated')]
    public function updateCount()
    {
        $cart = session()->get('cart', []);
        $this->cartCount = collect($cart)->sum('quantity');
    }

    public function mount()
    {
        $this->updateCount();
    }

    public function render()
    {
        return view('livewire.shop.cart-icon');
    }
}
