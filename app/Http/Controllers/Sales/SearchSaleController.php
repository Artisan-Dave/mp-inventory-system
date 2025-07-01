<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use Exception;

class SearchSaleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $search = $request->input('search');

        try {
            if ($search) {
                $sales = Sale::where('customer_name', "LIKE", "%{$search}%")
                    ->orWhere("total_amount", "LIKE", "%{$search}%")
                    ->orWhere("created_at", "LIKE", "%{$search}%")
                    ->paginate(10);
            } else {
                $sales = Sale::paginate(10);
            }
        }catch (Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
        return view('sales.index',compact('sales'));

    }
}
