<?php

namespace App\Console\Commands;

use App\Services\FakeStoreApiAdapter;
use App\Services\ProductImporter;
use Illuminate\Console\Command;

class ImportFakeStoreApiProducts extends Command
{
    /**
     * The name and signature of the console command.
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
     */
    public function handle(): void
    {
        $adapter = new FakeStoreApiAdapter();
        $importer = new ProductImporter($adapter);

        $importer->import();

        $this->info('Products imported successfully.');
    }
}
