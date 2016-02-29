<?php

namespace App\Services;

use App\Contracts\Storages\GraphStorageContract;
use App\Models\Swap;

class SwapsGraphService
{
    /**
     * @var GraphStorageContract
     */
    private $graphStorage;

    /**
     * SwapsGraphService constructor.
     * @param GraphStorageContract $graphStorage
     */
    public function __construct(GraphStorageContract $graphStorage)
    {
        $this->graphStorage = $graphStorage;
    }


    public function add(Swap $swap)
    {
        return $this->graphStorage->add($swap);
    }

    public function connect(Swap $swapA, Swap $swapB)
    {
        return $this->graphStorage->connectSwaps($swapA, $swapB);
    }
}
