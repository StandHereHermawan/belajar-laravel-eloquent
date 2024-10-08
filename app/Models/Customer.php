<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Date;

class Customer extends Model
{
    // use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
    protected  $with = ["wallet"];

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, "customer_id", "id");
    }

    public function virtualAccount(): HasOneThrough
    {
        return $this->hasOneThrough(
            VirtualAccount::class,
            Wallet::class,
            "customer_id", // Foreign key di tabel wallets
            "wallet_id", // Foreign key di tabel virtual_account
            "id", // PK di tabel customers
            "id" // PK di tabel wallets
        );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, "customer_id", "id");
    }

    public function likeProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, "customers_likes_products", "customer_id", "product_id")
            ->withPivot("created_at")
            ->using(Like::class);
    }

    public function likeProductsLastWeek(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, "customers_likes_products", "customer_id", "product_id")
            ->withPivot("created_at")
            ->wherePivot("created_at", ">=", Date::now()->addDays(-7))
            ->using(Like::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, "imageable");
    }
}
