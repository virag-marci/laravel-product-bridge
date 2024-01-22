<?php

namespace App\Services;

use App\Contracts\ProductImportAdapterContract;
use App\Models\Product;

class ProductImporter
{
    protected ProductImportAdapterContract $adapter;

    public function __construct(ProductImportAdapterContract $adapter)
    {
        $this->adapter = $adapter;
    }

    public function import(): void
    {
        $products = $this->adapter->getProducts();

        $products->each(function (Product $product) {
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
    }
}
