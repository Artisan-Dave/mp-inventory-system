<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Exception;

class SaveProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // dd($request);
        try {
            $data = $request->validate(
                [
                    'product_name' => 'required|string',
                    'category' => 'required|string',
                    'quantity' => 'required|numeric',
                    'price' => 'required|numeric',
                ]
            );

            $existingProduct = Product::where('product_name', $data['product_name'])->first();

            if ($existingProduct) {
                session()->flash('error', 'Product already added');
                return redirect()->back()->withInput();
            }

            // Start a database transaction (optional but recommended)
            \DB::beginTransaction();

            $newProduct = Product::create($data);

            // Commit the transaction (if using transactions)
            \DB::commit();

            session()->flash('success', 'Product added successfully!');
            return redirect(route('product.index'));

        } catch (Exception $e) {
            // Roll back the transaction (if using transactions)
            \DB::rollBack();

            // Log the error (optional)
            \Log::error('Adding product error: ' . $e->getMessage());

            // Flash an error message and redirect back
            session()->flash('error', 'An error occurred while processing. Please try again.');
            return redirect()->back()->withInput();
        }

    }
}
