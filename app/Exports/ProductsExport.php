<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private readonly array $productIDs) {}

    public function headings(): array
    {
        return [
            'Name',
            'Categories',
            'Country',
            'Price'
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->categories->pluck('name')->implode(', '),
            $row->country->name,
            '$' . number_format($row->price, 2)
        ];
    }

    public function collection(): Collection
    {
        return Product::with('categories', 'country')->find($this->productIDs);
    }
}
