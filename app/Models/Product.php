<?php

namespace App\Models;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'name',
        'photo',
        'description',
        'stocks',
        'type',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'stocks' => 'integer',
            'type' => ProductType::class,
        ];
    }

    protected $with = ['latestProductPrice'];

    // Relation gies here
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function productPrices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function productPhotoTypes(): HasMany
    {
        return $this->hasMany(ProductPhotoType::class);
    }

    public function latestProductPrice(): HasOne
    {
        return $this->hasOne(ProductPrice::class)->latestOfMany();
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Accessor goes here
    public function getCurrentPriceAttribute()
    {
        return $this->latestProductPrice?->price ?? 0;
    }
}
