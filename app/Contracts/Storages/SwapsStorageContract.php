<?php

namespace App\Contracts\Storages;

use App\Models\Swap;

/**
 * Interface SwapsStorageContract
 * @package App\Contracts\Storages
 */
interface SwapsStorageContract
{
    /**
     * @param array $columns
     * @param array $conditions
     * @param array $orders
     * @param int $limit
     * @return mixed
     */
    public function load(array $columns = ['*'], array $conditions = [], array $orders = [], $limit = 0);

    /**
     * @param Swap $swap
     * @return Swap
     */
    public function save(Swap $swap);

    /**
     * @param Swap $swap
     * @param \App\Models\Tag[] $tags
     * @return mixed
     */
    public function saveTags($swap, $tags);

    /**
     * @param Swap $swap
     * @param \App\Models\Keyword[] $keywords
     * @return mixed
     */
    public function saveKeywords($swap, $keywords);

    /**
     * @param Swap $swap
     * @param \App\Models\Wish[] $wishes
     * @return mixed
     */
    public function saveWishes($swap, $wishes);

    /**
     * @param string[] $wishKeywords
     * @param string[] $keywords
     * @return mixed
     */
    public function findByKeywords($wishKeywords, $keywords);
}
