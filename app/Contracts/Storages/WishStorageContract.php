<?php

namespace App\Contracts\Storages;

/**
 * Interface WishStorageContract
 * @package App\Contracts\Storages
 */
interface WishStorageContract
{

    /**
     * @param string[] $wishNames
     * @return \App\Models\Wish[]
     */
    public function findAll($wishNames);

    /**
     * @param \App\Models\Wish[] $wishes
     * @return \App\Models\Wish[]
     */
    public function saveAll($wishes);
}
