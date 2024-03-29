#!/bin/bash

# Copy the .env.example file to .env
cp .env.example .env
cp .env.testing.example .env.testing

# Install Composer dependencies
composer install --no-interaction

# Start the Sail containers with 'sail up'
./vendor/bin/sail up -d

# Echo a message indicating that we are waiting for the containers to start
echo "Waiting for for the containers to start..."
sleep 10

# Generate the application key
./vendor/bin/sail artisan key:generate

# Run database migrations
./vendor/bin/sail artisan migrate --seed

# Run tests
./vendor/bin/sail test --coverage-clover=coverage.xml

# Import products
./vendor/bin/sail artisan import-products:fake-store
