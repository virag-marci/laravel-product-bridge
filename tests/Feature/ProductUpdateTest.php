<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateProductWithValidDataAsAuthenticatedUser()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->json('PUT', route('products.product.update', [
                'product' => $product->id,
            ]), [
                'title' => 'New Title',
                'description' => 'New Description',
                'image' => 'newimage.jpg',
                'price' => 99.99,
            ])
            ->assertStatus(200)
            ->assertJson(['message' => 'Product updated successfully']);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => 'New Title',
            'description' => 'New Description',
            'image' => 'newimage.jpg',
            'price' => 99.99,
        ]);
    }

    public function testUpdateProductWithInvalidData()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->json('PUT', route('products.product.update', [
                'product' => $product->id,
            ]), [])
            ->assertStatus(422);
    }

    public function testUpdateProductAsUnauthenticatedUser()
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
