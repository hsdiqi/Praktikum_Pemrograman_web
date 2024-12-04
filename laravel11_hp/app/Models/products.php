<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'stok',
        'brand',
        'category',
        'bought'
    ];

    protected function image(): Attribute {
        return Attribute::make(
            get: fn ($image) => url('/storage/products/' . $image),
        );
    }
}
