<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'country_id',
        'price',
        'shop_id',
        'manufacturer_id',
        'brand',
        'name',
        'model_number',
        'mpn',
        'gtin',
        'gtin_type',
        'description',
        'min_price',
        'max_price',
        'origin_country',
        'requires_shipping',
        'downloadable',
        'slug',
        // 'meta_title',
        // 'meta_description',
        'sale_count',
        'active',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function orders(): belongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}
