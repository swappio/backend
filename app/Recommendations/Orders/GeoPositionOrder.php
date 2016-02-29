<?php

namespace App\Recommendations\Orders;

use App\Contracts\Recommendations\LoaderOrderContract;

/**
 * Class GeoPositionOrder
 * TODO: need to be implented properly
 *
 * @package App\Recommendations\Orders
 */
class GeoPositionOrder implements LoaderOrderContract
{
    /**
     * @var int
     */
    private $lat;

    /**
     * @var int
     */
    private $lng;

    /**
     * GeoPositionOrder constructor.
     * @param int $lat
     * @param int $lng
     */
    public function __construct($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }


    public function getOrderData()
    {
        return [
            [
                'expression' => true,
                'value' => 'DIFF(lat-' . $this->lat . ')',
                'direction' => 'ASC'
            ]
        ];
    }
}
