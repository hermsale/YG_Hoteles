<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * creo este componente para poder reutilizar el navbar en diferentes vistas
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}
