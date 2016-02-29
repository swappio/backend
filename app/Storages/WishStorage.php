<?php

namespace App\Storages;

use Illuminate\Database\Eloquent\Builder;
use App\Contracts\Storages\WishStorageContract;

/**
 * Class WishStorage
 * @package App\Storages
 */
class WishStorage implements WishStorageContract
{
    /**
     * @var Builder
     */
    private $queryBuilder;

    /**
     * SwapsStorage constructor.
     * @param Builder $queryBuilder
     */
    public function __construct(Builder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function findAll($wishNames)
    {
        $this->queryBuilder->whereIn('name', $wishNames);

        return $this->queryBuilder->get()->all();
    }

    /**
     * @param \App\Models\Wish[] $wishes
     * @return \App\Models\Wish[]
     */
    public function saveAll($wishes)
    {
        foreach ($wishes as $wish) {
            $wish->save();
        }

        return $wishes;
    }
}
