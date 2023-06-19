<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Country;

class ProductsList extends Component
{
    use WithPagination;

    public array $categories = [];

    public array $countries = [];

    public array $searchColumns = [
        'name' => '',
        'price' => ['', ''],
        'description' => '',
        'category_id' => 0,
        'country_id' => 0,
    ];

    public function mount(): void
    {
        $this->categories = Category::pluck('name', 'id')->toArray();
        $this->countries = Country::pluck('name', 'id')->toArray();
    }

    public function render(): Application | Factory | \Illuminate\Contracts\View\View | \Illuminate\Foundation\Application
    {
        $products = Product::query()
            ->select(['products.*', 'countries.id as countryId', 'countries.name as countryName',])
            ->join('countries', 'countries.id', '=', 'products.country_id')
            ->with('categories');

        foreach ($this->searchColumns as $column => $value) {
            if (!empty($value)) {
                $products->when($column == 'price', function ($products) use ($value) {
                    if (is_numeric($value[0])) {
                        $products->where('products.price', '>=', $value[0] * 100);
                    }
                    if (is_numeric($value[1])) {
                        $products->where('products.price', '<=', $value[1] * 100);
                    }
                })
                    ->when($column == 'category_id', fn($products) => $products->whereRelation('categories', 'id', $value))
                    ->when($column == 'country_id', fn($products) => $products->whereRelation('country', 'id', $value))
                    ->when($column == 'name', fn($products) => $products->where('products.' . $column, 'LIKE', '%' . $value . '%'));
            }
        }

        return view('livewire.products-list', [
            'products' => $products->paginate(10)
        ]);
    }
}
