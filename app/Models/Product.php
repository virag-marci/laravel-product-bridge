<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The Product model represents a product entity in the database.
 *
 * It uses soft deletes to allow recovery of deleted records.
 * The HasFactory trait enables the model to be associated with a factory for testing or seeding purposes.
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * Guarding these attributes prevents them from being mass-assigned during model creation or updates,
     * which enhances the security of the application.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The attributes casting.
     *
     * Casts the specified fields to the defined types when the model is retrieved or saved.
     * This ensures proper data type conversion and consistency throughout the application.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
        'rating_rate' => 'float',
        'rating_count' => 'integer',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * This method overrides the default model factory behavior,
     * specifying the custom factory to use for this model.
     * Useful in testing and seeding the database with Product instances.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }
}
