<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_name',
        'category',
        'quantity',
        'price'
    ];

    public function sales(){
        return $this->belongsToMany(Sale::class,'product_sale_pivot')
                    ->withPivot('quantity','price')
                    ->withTimestamps();
    }
}
