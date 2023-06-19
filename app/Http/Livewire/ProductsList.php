<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsList extends Component
{
    use WithPagination;

    public function render(): \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\View\Factory | \Illuminate\Contracts\View\View | \Illuminate\Foundation\Application
    {
        $products = Product::paginate(10);

        return view('livewire.products-list', [
            'products' => $products,
        ]);
    }
}
