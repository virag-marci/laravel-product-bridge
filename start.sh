#!/bin/bash

# Copy the .env.example file to .env
cp .env.example .env

# Start the Sail containers with 'sail up'
./vendor/bin/sail up -d

# Install Composer dependencies
./vendor/bin/sail composer install --no-interaction

# Generate the application key
./vendor/bin/sail artisan key:generate

# Run database migrations
./vendor/bin/sail artisan migrate --seed

# Run tests
./vendor/bin/sail test --coverage-clover=coverage.xml
