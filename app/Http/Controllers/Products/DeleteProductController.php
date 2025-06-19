<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteProductController extends BaseAdminController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        $product = Product::findOrFail($id)->delete();

        if($product){
            session()->flash('success','Product deleted Successfully');
            return redirect(route('product.index'));
        }

        if(!$product){
            session()->flash('error','Product Deletion Failed');
            return redirect(route('product.index'));
        }
    }
}
