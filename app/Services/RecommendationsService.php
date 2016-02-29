<?php

namespace App\Services;

use App\Recommendations\Loaders\AllLoader;
use App\Recommendations\Loaders\CompositeLoader;
use App\Recommendations\Orders\GeoPositionOrder;
use App\Models\Swap;
use App\Storages\SwapsStorage;

/**
 * Class RecommendationsService
 * @package App\Services
 */
class RecommendationsService
{
    /**
     * @return null|\App\Models\Swap[]
     */
    public function loadForGuest()
    {
        $loader = new AllLoader(new SwapsStorage(Swap::query()), [
            'limit' => 40
        ]);

        return $loader->load();
    }

    /**
     * @return null|\App\Models\Swap[]
     */
    public function loadForUser()
    {
        $loader = new CompositeLoader([
            new AllLoader(new SwapsStorage(Swap::query()), [
                'limit' => 30,
                'orders' => [
                    new GeoPositionOrder(1, 2)
                ]
            ]),
            new AllLoader(new SwapsStorage(Swap::query()), [
                'limit' => 10,
            ])
        ]);

        return $loader->load();
    }
}
