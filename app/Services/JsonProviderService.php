<?php

namespace App\Services;

class JsonProviderService
{
    protected $JsonFiles = [
        'DataProviderW',
        'DataProviderX',
        'DataProviderY'
    ];

    protected $allowedFilters = [
        'provider',
        'statusCode',
        'amountMin',
        'amountMax',
        'currency'
    ];

    public function getAllParents(array $filters = [])
    {
        $parents = [];
        //make sure that no other GET attribute is here
        $filters = $this->validateFilters($filters);

        //get list of valid data sources based on the request
        $dataSources = $this->getValidDataSources($filters);
        foreach ($dataSources as $dataSource){
            //apply filters on each data source
            $this->processFilters($dataSource, $filters);
            //combine all datasources data
            $parents = array_merge($parents, $dataSource->getAll());
        }
        return $parents;
    }

    protected function validateFilters(array $filters = [])
    {
        $allowedFilters = $this->allowedFilters;
        $filtered = array_filter(
            $filters,
            function ($key) use ($allowedFilters) {
                return in_array($key, $allowedFilters);
            },
            ARRAY_FILTER_USE_KEY
        );

        return $filtered;
    }

    protected function getValidDataSources(array $filters = []):array
    {
        $dataSources = [];

        if(array_key_exists('provider', $filters) && in_array($filters['provider'], $this->JsonFiles)){
            $dataSources[] = app('App\JsonFiles\\'.$filters['provider']);
        }else{
            foreach ($this->JsonFiles as $dataSource){
                $dataSources[] = app('App\JsonFiles\\'.$dataSource);
            }
        }

        return $dataSources;
    }

    protected function processFilters($dataSource, $filters = [])
    {
        if(!empty($filters)){
            if(array_key_exists('statusCode', $filters) && !empty($filters['statusCode'])){
                $dataSource->filterByStatus($filters['statusCode']);
            }
            if(array_key_exists('amountMin', $filters) && $filters['amountMin'] >= 0 && $filters['amountMin'] != ''){

                $dataSource->filterByBalanceMin($filters['amountMin']);
            }
            if(array_key_exists('amountMax', $filters) && $filters['amountMax'] >= 0 && $filters['amountMax'] != ''){
                $dataSource->filterByBalanceMax($filters['amountMax']);
            }
            if(array_key_exists('currency', $filters) && !empty($filters['currency'])){
                $dataSource->filterByCurrency($filters['currency']);
            }
        }
    }
}
