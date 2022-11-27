<?php

namespace App\JsonFiles;

class DataProviderTestW extends AbstractDataProvider
{
    protected $storageFolder = "dataproviders/tests";
    protected $fileName      = "DataProviderTestW.json";
    protected $filters       = [];

    protected $statusCodes = [
        'paid'       => 'paid',
        'pending'    => 'pending',
        'rejected'   => 'rejected'
    ];

    public function filterByStatus(string $status)
    {
        $this->filters[] = [
            'name'      => 'status',
            'value'     => $this->statusCodes[$status],
            'operator'  => '='
        ];
    }

    public function filterByBalanceMin(int $from)
    {
        $this->filters[] = [
            'name'        => 'amount',
            'value'       => $from,
            'operator'    => '>='
        ];
    }

    public function filterByBalanceMax(int $to)
    {
        $this->filters[] = [
            'name'       => 'amount',
            'value'      => $to,
            'operator'   => '<='
        ];
    }

    public function filterByCurrency(string $currency)
    {
        $this->filters[] = [
            'name'       => 'currency',
            'value'      => $currency,
            'operator'   => '='
        ];
    }

}
