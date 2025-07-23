<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class RefundSaleController extends BaseAdminController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        // dd($id);

        $sale = Sale::findOrFail($id);


        if ($sale->refunded) {
            return back()->with('error', 'This sale has already been refunded.');
        }

        foreach ($sale->products as $product) {
            $refundedQuantity = $product->pivot->quantity;
            $product->increment('quantity', $refundedQuantity);
        }

        // $sale->update([
        //     'refunded' => true,
        //     'total_amount' => 0,
        // ]);

        $sale->update(['refunded' => true]);

        return redirect(route('sale.index'))->with('success', 'Refund completed.');

    }
}
