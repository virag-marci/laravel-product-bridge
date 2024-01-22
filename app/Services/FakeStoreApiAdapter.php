<?php

namespace App\Services;

use App\Contracts\ProductImportAdapterContract;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class FakeStoreApiAdapter implements ProductImportAdapterContract
{
    /**
     * Fetches products data from the FakeStore API.
     *
     * @return array
     */
    public function fetchProducts(): array
    {
        $response = Http::get('https://fakestoreapi.com/products');
        return $response->json();
    }

    /**
     * Gets products and transforms them into Product model instances.
     *
     * @return Collection
     */
    public function getProducts(): Collection
    {
        $apiProducts = $this->fetchProducts();

        return collect(array_map(function ($productData) {
            return new Product([
                'external_id' => $productData['id'],
                'title'       => $productData['title'],
                'price'       => $productData['price'],
                'description' => $productData['description'],
                'category'    => $productData['category'],
                'image'       => $productData['image'],
                'rating_rate' => $productData['rating']['rate'],
                'rating_count' => $productData['rating']['count'],
            ]);
        }, $apiProducts));
    }
}
