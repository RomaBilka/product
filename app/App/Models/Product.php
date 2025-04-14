<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    const UPDATED_AT = null;
    protected $keyType = 'string';
    protected $fillable = ['name', 'price', 'category_id', 'attributes'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
