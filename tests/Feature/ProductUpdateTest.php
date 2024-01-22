<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider validProductDataProvider
     */
    public function test_update_product_as_authenticated_user($data)
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->json('PUT', route('products.product.update', [
                'product' => $product->id,
            ]), $data)
            ->assertStatus(200)
            ->assertJson(['message' => 'Product updated successfully']);

        $this->assertDatabaseHas('products', $data);
    }

    /**
     * Data provider for valid product update data.
     */
    public static function validProductDataProvider(): array
    {
        return [
            'valid data 1' => [
                [
                    'title' => 'New Title',
                    'description' => 'New Description',
                    'image' => 'newimage.jpg',
                    'price' => 99.99,
                ]
            ],
            'valid data 2' => [
                [
                    'title' => 'New Title 2',
                    'description' => 'New Description 2',
                    'image' => 'newimage2.jpg',
                    'price' => 199.99,
                ]
            ],
            'valid data 3' => [
                [
                    'title' => 'New Title 3',
                    'description' => 'New Description 3',
                    'image' => 'newimage3.jpg',
                    'price' => 299.99,
                ]
            ],
        ];
    }

    /**
     * @dataProvider invalidProductDataProvider
     */
    public function test_update_product_with_invalid_data_as_authenticated_user($data)
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->json('PUT', route('products.product.update', [
                'product' => $product->id,
            ]), $data)
            ->assertStatus(422);
    }

    /**
     * Data provider for invalid product update data.
     */
    public static function invalidProductDataProvider(): array
    {
        return [
            'empty data' => [
                []
            ],
            'invalid price' => [
                [
                    'title' => 'New Title',
                    'description' => 'New Description',
                    'image' => 'newimage.jpg',
                    'price' => 'invalid',
                ]
            ],
            'invalid image' => [
                [
                    'title' => 'New Title',
                    'description' => 'New Description',
                    'image' => null,
                    'price' => 99.99,
                ]
            ],
            'invalid title' => [
                [
                    'title' => '',
                    'description' => 'New Description',
                    'image' => 'newimage.jpg',
                    'price' => 99.99,
                ]
            ],
        ];
    }

    public function test_update_product_as_guest()
    {
        $product = Product::factory()->create();

        $this->json('PUT', route('products.product.update', [
            'product' => $product->id,
        ]), [
            'title' => 'New Title',
            'description' => 'New Description',
            'image' => 'newimage.jpg',
            'price' => 99.99,
        ])
            ->assertStatus(401);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
            'title' => 'New Title',
            'description' => 'New Description',
            'image' => 'newimage.jpg',
            'price' => 99.99,
        ]);
    }

}
