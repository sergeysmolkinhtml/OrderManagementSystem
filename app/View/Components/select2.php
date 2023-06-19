<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class Select2 extends Component
{
    public function __construct(public mixed $options)
    {}

    public function render(): View
    {
        return view('components.select2');
    }
}
