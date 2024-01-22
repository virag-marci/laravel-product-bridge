<?php

namespace App\Services;

use App\Contracts\ProductImportAdapterContract;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductImporter
{
    /**
     * The adapter to import products.
     *
     * @var ProductImportAdapterContract
     */
    protected ProductImportAdapterContract $adapter;

    /**
     * Create a new ProductImporter instance.
     *
     * @param ProductImportAdapterContract $adapter
     */
    public function __construct(ProductImportAdapterContract $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Import products using the adapter.
     * @throws Throwable
     */
    public function import(): void
    {
        try {
            $products = $this->adapter->getProducts();

            $products->each(function (Product $product) {
                // Attempt to update existing products or create new ones
                Product::query()->updateOrCreate([
                    'external_id' => $product->external_id,
                ], [
                    'title'       => $product->title,
                    'price'       => $product->price,
                    'description' => $product->description,
                    'category'    => $product->category,
                    'image'       => $product->image,
                    'rating_rate' => $product->rating_rate,
                    'rating_count' => $product->rating_count,
                ]);
            });

            Log::info('Products imported successfully.');
        } catch (Throwable $e) {
            // Log the error for debugging purposes
            Log::error("An error occurred during product import: {$e->getMessage()}");
            throw $e;
        }
    }
}
