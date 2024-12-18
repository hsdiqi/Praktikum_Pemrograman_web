<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'category',
        'description',
        'price',
        'stock',
        'bought',
        'year',
        'image',
    ];

    protected function image(): Attribute 
    { 
        return Attribute::make( 
            get: fn ($image) => url('/storage/product/' . $image), 
        ); 
    } 
}
