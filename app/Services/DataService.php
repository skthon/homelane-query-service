<?php

namespace App\Services;

use App\Traits\ConsumesExternalServices;

class DataService
{
    use ConsumesExternalServices;

    /**
     * Base url of the data service
     */
    public $baseUrl;

    /**
     * Headers that need to be sent to the data service request
     *
     * @var array
     */
    public $headers;

    public function __construct()
    {
        $this->baseUrl = config('data_service.base_url');
        $this->headers = [
            'Accept' => 'application/json'
        ];
    }

    /**
     * Get homes that can be bought between the mentioned price range
     *
     * @param int $minPrice
     * @param int $maxPrice
     * @return array
     */
    public function getHomesByPrice($minPrice, $maxPrice): array
    {
        return $this->makeRequest('POST', '/api/data', [], [
            'min_price' => $minPrice,
            'max_price' => $maxPrice
        ]);
    }

    /**
     * Get homes with sqft_living greater than the specified value
     *
     * @param  int   $year
     * @return array
     */
    public function getHomesBySqft($minSqft): array
    {
        return $this->makeRequest('POST', '/api/data', [], [
            'min_sqft_living' => $minSqft
        ]);
    }

    /**
     * Get homes which are either built or renovated after the specified year
     *
     * @param  int   $year
     * @return array
     */
    public function getHomesByYear($year): array
    {
        return $this->makeRequest('POST', '/api/data', [], [
            'min_year' => $year
        ]);
    }

    /**
     * Get homes along with the standardized prices
     *
     * @return array
     */
    public function getHomesWithStandardizedPrices(): array
    {
        return $this->makeRequest('POST', '/api/data', [], [
            'standardized_price' => true
        ]);
    }
}
