<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductPrice extends Model
{
    protected $fillable = [
        'product_id',
        'price',
        'discount_number',
        'discount_percent',
    ];

    protected $casts = [
        'price' => 'integer',
        'discount_number' => 'integer',
        'discount_percent' => 'float',
    ];

    // Relation goes here
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Accessor goes here
    public function getFinalPriceAttribute(): int
    {
        $price = $this->price;

        if (!is_null($this->discount_number) && $this->discount_number > 0) {
            $price -= $this->discount_number;
        } elseif (!is_null($this->discount_percent) && $this->discount_percent > 0) {
            $discount = intval(round($price * $this->discount_percent / 100));
            $price -= $discount;
        }

        return max($price, 0);
    }
}
