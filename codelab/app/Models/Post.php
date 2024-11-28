<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'brand',
        'category',
        'tahun_rilis',
        'price',
        'stok',
        'muchBought',
        'image',
        'description'
    ];

    protected function image(): Attribute{
        return Attribute::make(
            get: fn ($image) => asset('/storage/posts/' . $image ),
        );
    }

}
