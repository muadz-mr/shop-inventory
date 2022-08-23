<?php

namespace App\Models;

use App\Enums\ProductPostStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'product_category_id' => 'integer',
        'currency_id' => 'integer',
        'price' => 'decimal:2',
        'posted_at' => 'datetime',
        'status' => ProductPostStatus::class,
    ];

    protected $fillable = ['product_category_id', 'name', 'slug', 'description', 'currency_id', 'price', 'status', 'posted_at', 'platform'];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productAttachments(): HasMany
    {
        return $this->hasMany(ProductAttachment::class);
    }
}
