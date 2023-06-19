<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;

class CategoriesList extends Component
{
    use WithPagination;

    public Category $category;

    public Collection $categories;

    public bool $showModal = false;

    public array $active = [];

    public int $currentPage = 1;

    public int $perPage = 10;

    public function openModal()
    {
        $this->showModal = true;

        $this->category = new Category();
    }

    public function render(): View
    {
        $cats = Category::orderBy('position')->paginate($this->perPage);
        $links = $cats->links();
        $this->currentPage = $cats->currentPage();
        $this->categories = collect($cats->items());

        $this->active = $this->categories->mapWithKeys(
            fn (Category $item) => [$item['id'] => (bool) $item['is_active']]
        )->toArray();

        return view('livewire.categories-list', ['links' => $links, ]);
    }

    public function updatedCategoryName()
    {
        $this->category->slug = Str::slug($this->category->name);
    }

    protected function rules(): array
    {
        return [
            'category.name' => ['required', 'string', 'min:3'],
            'category.slug' => ['nullable', 'string'],
        ];
    }

    public function updateOrder($list)
    {
        foreach ($list as $item) {
            $cat = $this->categories->firstWhere('id', $item['value']);
            $order = $item['order'] + (($this->currentPage - 1) * $this->perPage);

            if ($cat['position'] != $order) {
                Category::where('id', $item['value'])->update(['position' => $order]);
            }
        }
    }

    public function save()
    {
        $this->validate();

        $this->category->position = Category::max('position') + 1;

        $this->category->save();

        $this->reset('showModal');
    }

    public function toggleIsActive($categoryId)
    {
        Category::where('id', $categoryId)->update([
            'is_active' => $this->active[$categoryId],
        ]);
    }

}
