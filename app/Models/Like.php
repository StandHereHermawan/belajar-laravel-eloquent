<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Like extends Pivot
{
    // use HasFactory;

    protected  $table = "customers_likes_products";
    protected  $foreignKey = "customer_id";
    protected  $relatedKey = "product_id";
    public $timestamps = false;

    public function usesTimestamps(): bool // overrides purpose
    {
        return false;
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
