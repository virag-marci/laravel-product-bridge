# Project Setup and Workflow Documentation

This document outlines the steps and configurations used in setting up the project, including the use of Laravel Sail for container management, the implementation of CI/CD with GitHub Actions, and the use of specific endpoints and commands.

## Setup Script (`start.sh`)

The `start.sh` script is designed to automate the setup process for the application. It includes the following steps:

- **Environment File Setup**:
    - Copies `.env.example` to `.env`.
    - Copies `.env.testing.example` to `.env.testing`.

- **Composer Dependencies**:
    - Installs Composer dependencies without user interaction.

- **Docker Containers**:
    - Starts the Sail containers in detached mode.

- **Application Key**:
    - Generates the application key using Artisan.

- **Database Migrations**:
    - Runs database migrations and seeds the database.

- **Testing**:
    - Executes tests and generates a coverage report in XML format.

- **Product Import**:
    - Imports products using a custom Artisan command from the fake store API.

```bash
cp .env.example .env
cp .env.testing.example .env.testing

composer install --no-interaction

./vendor/bin/sail up -d

./vendor/bin/sail artisan key:generate

./vendor/bin/sail artisan migrate --seed

./vendor/bin/sail test --coverage-clover=coverage.xml

./vendor/bin/sail artisan import-products:fake-store

```
# API Endpoints
## Authentication:
- **POST api/auth/login** - Parameters: email, password.

## User Profile:
- **GET|HEAD api/user** - Requires an Authorization header with a bearer token obtained from the login endpoint.

## Products:
- **PUT api/products/product/{product}** - Parameters: title, description, image, price.

# Artisan Commands
php artisan import-products:fake-store: Imports products from the fake store API.

# Contracts and Services
## Contracts:
- **ProductImportAdapterContract:**
  - A contract for the product import adapter.
  
## Services:
- **FakeStoreApiAdapter:** 
  - An adapter for the fake store API, implementing ProductImportAdapterContract.
- **ProductImport:** 
  - A service that expects ProductImportAdapterContract and imports products from an API.

# GitHub Actions:
- **.github/workflows/sonarcloud.yml:**
  - Manages the coverage report to SonarCloud and performs SonarCloud analysis.
  Triggered on pushes to master and develop branches, as well as pull requests to these branches.
  Merging is prevented if the analysis fails.

# Commit Standards
- **Commit messages adhere to the Conventional Commits standard.**
- **Commits are signed to verify authenticity.**
