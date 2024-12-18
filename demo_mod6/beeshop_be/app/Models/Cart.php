<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity',
    ];
    
    public function Product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function Customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
