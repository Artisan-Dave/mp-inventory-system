<?php

namespace App\Http\Controllers\Products;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $search = $request->input("search");
        
        try {   
            if($search){
                $products = Product::where('product_name', 'LIKE', "%{$search}%")
                ->orWhere("category","LIKE", "%{$search}%")
                ->orWhere("quantity","LIKE", "%{$search}%")
                ->orWhere("price","LIKE", "%{$search}%")
                ->paginate(10);
            }
            else{
                $products = Product::paginate(10);
            }
        }
        catch (\Exception $e) {
            session()->flash('error','Something went wrong!');
            return redirect(route('product.index'));
        }
        return view('products.index',compact('products'));
    }
}
