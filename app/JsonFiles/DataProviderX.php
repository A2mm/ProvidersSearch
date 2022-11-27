<?php

namespace App\JsonFiles;

class DataProviderX extends AbstractDataProvider
{

    protected $fileName = "DataProviderX.json";

    protected $filters = [];

    protected $statusCodes = [
        'paid'       => 1,
        'pending'    => 2,
        'rejected'   => 3
    ];

    public function filterByStatus(string $status)
    {
        $this->filters[] = [
            'name' => 'status',
            'value' => $this->statusCodes[$status],
            'operator' => '='
        ];
    }

    public function filterByBalanceMin(int $from)
    {
        $this->filters[] = [
            'name' => 'transactionAmount',
            'value' => $from,
            'operator' => '>='
        ];
    }

    public function filterByBalanceMax(int $to)
    {
        $this->filters[] = [
            'name' => 'transactionAmount',
            'value' => $to,
            'operator' => '<='
        ];
    }

    public function filterByCurrency(string $currency)
    {
        $this->filters[] = [
            'name' => 'currency',
            'value' => $currency,
            'operator' => '='
        ];
    }
}
