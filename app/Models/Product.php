<?php

namespace App\Models;

use App\Enums\ProductStatus;
use App\Events\ProductDeleted;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'quantity' => 'integer',
        'attachments' => 'array',
        'posted_at' => 'datetime',
        'status' => ProductStatus::class,
    ];

    protected $fillable = ['product_category_id', 'name', 'slug', 'brand', 'description', 'currency_id', 'price', 'quantity', 'attachments', 'status', 'posted_at'];

    protected $appends = ['main_image', 'status_description'];

    protected function statusDescription(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return [
                    'description' => ProductStatus::getDescription($attributes['status'])
                ];
            },
        );
    }

    protected function mainImage(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return json_decode($attributes['attachments'])[0];
            },
        );
    }

    protected $dispatchesEvents = [
        'deleted' => ProductDeleted::class,
    ];

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
