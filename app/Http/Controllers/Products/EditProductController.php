<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class EditProductController extends BaseAdminController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit',['product'=>$product]);
    }
}
