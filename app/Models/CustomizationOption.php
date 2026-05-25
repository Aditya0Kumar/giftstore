<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomizationOption extends Model
{
    protected $fillable = ['product_id', 'type', 'name', 'values', 'additional_cost'];

    protected function casts(): array
    {
        return [
            'values' => 'array',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
