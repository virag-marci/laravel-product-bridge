<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Update the specified product properties in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            $product->fill($request->only([
                'title',
                'description',
                'image',
                'price',
            ]));
            $product->save();

            Log::info("Product updated successfully. Product ID: {$product->id}");

            return response()->json(['message' => 'Product updated successfully'], 200);
        } catch (\Exception $e) {

            Log::error("Error updating product. Product ID: {$product->id}. Error message: {$e->getMessage()}");

            return response()->json(['message' => 'An error occurred while updating the product'], 500);
        }
    }
}
