<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;
    protected $fillable = ['customer_name','total_amount','refunded'];

    public function products(){
        return $this->belongsToMany(Product::class,'product_sale_pivot')
                    ->withPivot('quantity','price')
                    ->withTimestamps();
    }
}
