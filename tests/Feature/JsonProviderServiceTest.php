<?php

namespace Tests\Feature;

use App\Services\JsonProviderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JsonProviderServiceTest extends TestCase
{
    protected $JsonProviderService;

    protected function setUp(): void
    {
        parent::setUp();
        //add test data provider
        $JsonProviderService                = app(JsonProviderService::class);
        $JsonProviderServiceUpdated         = new \ReflectionClass($JsonProviderService);
        $dataSourcesProperty                = $JsonProviderServiceUpdated->getProperty('JsonFiles');
        $dataSourcesProperty->setAccessible(true);
        $dataSourcesProperty->setValue($JsonProviderService,['DataProviderTestW', 'DataProviderTestX', 'DataProviderTestY']);
        $this->JsonProviderService = $JsonProviderService;
    }

    public function testParentsListingFromAllSources()
    {
        $output = $this->JsonProviderService->getAllParents();
        $this->assertEquals(15, count($output));
    }

    public function testParentsFromOneProviderFilter()
    {
        $filtersW = [
            'provider' => 'DataProviderTestW'
        ];
        $outputW = $this->JsonProviderService->getAllParents($filtersW);
        $this->assertEquals(5, count($outputW));

        $filtersX = [
            'provider' => 'DataProviderTestX'
        ];
        $outputX = $this->JsonProviderService->getAllParents($filtersX);
        $this->assertEquals(5, count($outputX));

        $filtersY = [
            'provider' => 'DataProviderTestY'
        ];
        $outputY = $this->JsonProviderService->getAllParents($filtersY);
        $this->assertEquals(5, count($outputY));
    }

    public function testParentsWithStatusFilter()
    {
        $filters = [
            'statusCode' => 'paid'
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(7, count($output));

        $filters_decline = [
            'statusCode' => 'pending'
        ];
        $output_decline = $this->JsonProviderService->getAllParents($filters_decline);
        $this->assertEquals(4, count($output_decline));

        $filters_refunded = [
            'statusCode' => 'rejected'
        ];
        $output_refunded = $this->JsonProviderService->getAllParents($filters_refunded);
        $this->assertEquals(4, count($output_refunded));
    }

    public function testParentsWithMinBalanceFilter()
    {
        $filters = [
            'amountMin' => 0
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(15, count($output));

        $filters = [
            'amountMin' => 150
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(10, count($output));

        $filters = [
            'amountMin' => 500
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(2, count($output));
    }

    public function testParentsWithMaxBalanceFilter()
    {
        $filters = [
            'amountMax' => 200
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(5, count($output));

        $filters = [
            'amountMax' => 400
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(13, count($output));

        $filters = [
            'amountMax' => 0
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(0, count($output));
    }

    public function testParentsWithCurrencyFilter()
    {
        $filters = [
            'currency' => 'EUR'
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(5, count($output));

        $filters = [
            'currency' => 'SAR'
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(3, count($output));

        $filters = [
            'currency' => 'AED'
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(0, count($output));

        $filters = [
            'currency' => 'USD'
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(3, count($output));

        $filters = [
            'currency' => 'EGP'
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(4, count($output));
    }

    public function testParentsWithAllFilters()
    {
        $filters = [
            'provider'   => 'DataProviderTestX',
            'statusCode' => 'rejected',
            'amountMin'  => 10,
            'amountMax'  => 140,
            'currency'   => 'EGP'
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(1, count($output));
    }

    public function testNotFoundDataSource()
    {
        $this->assertTrue(true);
    }
}

