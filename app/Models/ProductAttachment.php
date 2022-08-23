<?php

namespace App\Models;

use App\Enums\ProductAttachmentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAttachment extends Model
{
    use HasFactory;

    protected $casts = [
        'product_id' => 'integer',
        'type' => ProductAttachmentType::class,
    ];

    protected $fillable = ['product_id', 'display_order', 'title', 'path', 'type'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
