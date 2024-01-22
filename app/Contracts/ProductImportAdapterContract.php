<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Defines the contract for product import adapters.
 *
 * This interface outlines the methods that any product import adapter must implement,
 * allowing for different implementations to fetch and transform products data from various sources.
 */
interface ProductImportAdapterContract
{
    /**
     * Fetches raw products data from an external source.
     *
     * This method should be responsible for making an API call (or any other method of data retrieval)
     * to an external source and returning the raw data as an array.
     *
     * @return array The raw products data from the external source.
     */
    public function fetchProducts(): array;

    /**
     * Transforms raw data into an array of Product model instances.
     *
     * This method should take the raw data fetched by fetchProducts and transform it
     * into an array of Product model instances, ready to be processed or saved into the database.
     *
     * @return Collection A collection of Product model instances.
     */
    public function getProducts(): Collection;
}
