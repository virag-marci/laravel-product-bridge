<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\ProductImporter;
use App\Contracts\ProductImportAdapterContract;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Mockery;
use Throwable;

class ProductImporterTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test_import_success()
    {
        $this->app['config']->set('logging.default', 'test_log');
        $logHandler = new \Monolog\Handler\TestHandler();

        app('log')->driver()->setHandlers([$logHandler]);

        // Mock the ProductImportAdapterContract
        $mockAdapter = Mockery::mock(ProductImportAdapterContract::class);
        $mockAdapter->shouldReceive('getProducts')
            ->once()
            ->andReturn(collect([new Product(
                [
                    'external_id' => 1,
                    'title' => 'Test Product',
                    'price' => 10.99,
                    'description' => 'Test Description',
                    'category' => 'Test Category',
                    'image' => 'https://via.placeholder.com/150',
                    'rating_rate' => 4.5,
                    'rating_count' => 100,
                ]
            )]));

        // Instance of ProductImporter
        $importer = new ProductImporter($mockAdapter);

        // Call import method
        $importer->import();

        // Assert that log message was added
        $this->assertTrue($logHandler->hasInfo('Products imported successfully.'));
    }



    public function test_import_failure()
    {
        $mockAdapter = Mockery::mock(ProductImportAdapterContract::class);
        $mockAdapter->shouldReceive('getProducts')
            ->once()
            ->andThrow(new \Exception('Test Exception'));

        $importer = new ProductImporter($mockAdapter);

        $this->expectException(Throwable::class);

        // Call import method
        $importer->import();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
