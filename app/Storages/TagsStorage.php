<?php

namespace App\Storages;

use Illuminate\Database\Eloquent\Builder;
use App\Contracts\Storages\TagsStorageContract;

/**
 * Class TagsStorage
 * @package App\Storages
 */
class TagsStorage implements TagsStorageContract
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

    public function findAll($tagNames)
    {
        $this->queryBuilder->whereIn('name', $tagNames);

        return $this->queryBuilder->get()->all();
    }

    /**
     * @param \App\Models\Tag[] $tags
     * @return \App\Models\Tag[]
     */
    public function saveAll($tags)
    {
        foreach ($tags as $tag) {
            $tag->save();
        }

        return $tags;
    }
}
