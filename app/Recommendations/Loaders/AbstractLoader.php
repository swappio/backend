<?php

namespace App\Recommendations\Loaders;

use App\Contracts\Recommendations\LoaderContract;
use App\Contracts\Recommendations\LoaderFilterContract;
use App\Contracts\Recommendations\LoaderOrderContract;
use App\Contracts\Storages\SwapsStorageContract;

/**
 * Class AbstractLoader
 * @package App\Recommendations\Loaders
 */
abstract class AbstractLoader implements LoaderContract
{

    private $storage;

    private $limit = 0;

    private $conditions = [];

    private $orders = [];

    public function __construct(SwapsStorageContract $storage, array $config = [])
    {
        $this->storage = $storage;

        if (array_key_exists('limit', $config)) {
            $this->limit = $config['limit'];
        }

        if (array_key_exists('filters', $config)) {
            $this->applyFilters($config['filters']);
        }

        if (array_key_exists('orders', $config)) {
            $this->applyOrders($config['orders']);
        }
    }

    /**
     * @param array $columns
     * @return \App\Models\Swap[]|null
     */
    public function load(array $columns = ['*'])
    {
        return $this->storage->load($columns, $this->conditions, $this->orders, $this->limit);
    }

    /**
     * @param LoaderFilterContract[] $filters
     */
    private function applyFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $this->conditions = array_merge($this->conditions, $filter->getFilterData());
        }
    }

    /**
     * @param LoaderOrderContract[] $orders
     */
    private function applyOrders(array $orders)
    {
        foreach ($orders as $order) {
            $this->orders = array_merge($this->orders, $order->getOrderData());
        }
    }
}
