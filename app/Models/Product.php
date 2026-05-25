<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'category', 'base_price', 'image_url', 'rating', 'reviews_count', 'specifications'];

    protected $casts = [
        'specifications' => 'array',
    ];

    public function customizationOptions()
    {
        return $this->hasMany(CustomizationOption::class);
    }

    public function pricingRules()
    {
        return $this->hasMany(PricingRule::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
