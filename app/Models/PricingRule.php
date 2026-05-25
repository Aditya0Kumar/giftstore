<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingRule extends Model
{
    protected $fillable = ['product_id', 'condition_key', 'operator', 'condition_value', 'price_adjustment', 'type'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
