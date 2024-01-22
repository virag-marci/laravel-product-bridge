<?php

namespace App\Console\Commands;

use App\Services\FakeStoreApiAdapter;
use App\Services\ProductImporter;
use Illuminate\Console\Command;
use Throwable;

class ImportFakeStoreApiProducts extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'import-products:fake-store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from the FakeStore API (https://fakestoreapi.com)';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws Throwable
     */
    public function handle(): void
    {
        // Initialize services
        $adapter = new FakeStoreApiAdapter();
        $importer = new ProductImporter($adapter);

        try {
            $importer->import();
            $this->info('Products imported successfully.');
        } catch (Throwable $e) {
            // Log the error or handle it as required
            $this->error("An error occurred during import: " . $e->getMessage());
            throw $e;
        }
    }
}
