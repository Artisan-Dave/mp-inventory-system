<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['customer_name','total_amount'];

    public function products(){
        return $this->belongsToMany(Product::class,'product_sale_pivot')
                    ->withPivot('quantity','price')
                    ->withTimestamps();
    }
}
