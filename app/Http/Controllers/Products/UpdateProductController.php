<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class UpdateProductController extends BaseAdminController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request,$id)
    {
        $data = $request->validate([
            'product_name' => 'required|string',
            'category' => 'required|string',
            'quantity' =>'required|numeric',
            'price'=> 'required|numeric',
        ]);

        $existingProduct = Product::where('product_name',$data['product_name'])
            ->where('category',$data['category'])
            ->where('quantity',$data['quantity'])
            ->where('price',$data['price'])
            ->first();

        if($existingProduct){
            session()->flash('error', 'Product already added');
            return redirect()->back()->withInput();
        }

        $product = Product::findOrFail($id);
        $updated = $product->update($data);

        if ($updated) {
            session()->flash('success', 'Product updated successfully!');
            return redirect(route('product.index'));
        } else {
            session()->flast('error', 'Some problem occured');
            return redirect()->back()->withInput();
        }
    }
}
