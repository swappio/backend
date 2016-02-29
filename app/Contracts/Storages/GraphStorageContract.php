<?php

namespace App\Contracts\Storages;

use Everyman\Neo4j\Node;
use App\Models\Swap;

/**
 * Interface GraphStorageContract
 * @package App\Contracts\Storages
 */
interface GraphStorageContract
{
    /**
     * @param Swap $swap
     * @return mixed
     */
    public function add(Swap $swap);

    /**
     * @param int $id
     * @return Node
     */
    public function find($id);

    /**
     * @param Swap $swapA
     * @param Swap $swapB
     * @return bool
     */
    public function connectSwaps(Swap $swapA, Swap $swapB);
}
