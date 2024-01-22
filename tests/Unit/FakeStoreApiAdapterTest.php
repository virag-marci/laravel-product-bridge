<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\FakeStoreApiAdapter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FakeStoreApiAdapterTest extends TestCase
{
    public function test_fetch_products()
    {
        Http::fake([
            'https://fakestoreapi.com/products' => Http::response([
                ['id' => 1, 'title' => 'Product 1', 'price' => 100.0],
            ], 200),
        ]);

        $adapter = new FakeStoreApiAdapter();
        $products = $adapter->fetchProducts();

        $this->assertIsArray($products);
        $this->assertEquals('Product 1', $products[0]['title']);
    }

    public function test_get_products()
    {
        Http::fake([
            'https://fakestoreapi.com/products' => Http::response([
                ['id' => 1, 'title' => 'Product 1', 'price' => 100.0, 'description' => 'Test Description', 'category' => 'Test Category', 'image' => 'https://via.placeholder.com/150', 'rating' => ['rate' => 4.5, 'count' => 100]],
            ], 200),
        ]);

        $adapter = new FakeStoreApiAdapter();
        $products = $adapter->getProducts();

        $this->assertInstanceOf(Collection::class, $products);
        $this->assertCount(1, $products);
        $this->assertInstanceOf(Product::class, $products->first());
        $this->assertEquals('Product 1', $products->first()->title);
    }
}
