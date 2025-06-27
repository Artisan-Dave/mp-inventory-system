<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class ShowAllSalesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $sales = Sale::with('products')->latest()->paginate(10);
        return view('sales.index',compact('sales'));
    }
}
