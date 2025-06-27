<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaveSaleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'products' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            $sale = Sale::create(['customer_name' => $request->customer_name]);

            $total = 0;

            foreach ($request->products as $productId => $details) {
                $quantity = (int) $details['quantity'];
                $price = (float) $details['price'];


                if ($quantity > 0) {
                    $product = Product::findOrFail($productId);

                    if ($product->quantity < $quantity) {
                        throw new \Exception("Not enough stock for product {$product->product_name}");
                    }

                    $sale->products()->attach($productId, [
                        'quantity' => $quantity,
                        'price' => $price
                    ]);

                    $product->decrement('quantity', $quantity);
                    $total += $price * $quantity;
                }
            }

            $sale->update(['total_amount' => $total]);
        });

        return redirect()->route('sale.index')->with('success', 'Sale recorded successfully.');
    }
}
