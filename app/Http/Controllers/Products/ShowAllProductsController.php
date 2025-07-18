<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ShowAllProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
         $products = Product::orderBy('created_at', 'desc')->paginate(10);
         return view('products.index',['products' => $products]);
    }
}
