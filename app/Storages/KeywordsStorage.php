<?php

namespace App\Storages;

use Illuminate\Database\Eloquent\Builder;
use App\Contracts\Storages\KeywordsStorageContract;

/**
 * Class KeywordsStorage
 * @package App\Storages
 */
class KeywordsStorage implements KeywordsStorageContract
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

    public function findAll($keywordNames)
    {
        $this->queryBuilder->whereIn('name', $keywordNames);

        return $this->queryBuilder->get()->all();
    }

    /**
     * @param \App\Models\Keyword[] $keywords
     * @return \App\Models\Keyword[]
     */
    public function saveAll($keywords)
    {
        foreach ($keywords as $keyword) {
            $keyword->save();
        }

        return $keywords;
    }
}
