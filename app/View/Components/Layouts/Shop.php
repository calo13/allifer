<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class Shop extends Component
{
    public function render(): View
    {
        return view('components.layouts.shop');
    }
}