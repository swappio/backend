<?php

namespace App\Storages;

use Illuminate\Database\Eloquent\Builder;
use App\Contracts\Storages\SwapsStorageContract;
use App\Models\Swap;

class SwapsStorage implements SwapsStorageContract
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


    public function load(array $columns = ['*'], array $conditions = [], array $orders = [], $limit = 0)
    {
        $queryBuilder = $this->getQueryBuilder();

        foreach ($conditions as $condition) {
            $queryBuilder->where($condition['column'], $condition['operator'], $condition['value']);
        }

        $query = $queryBuilder->getQuery();
        $query->select($columns);

        foreach ($orders as $order) {
            if ($order['expression']) {
                $columnName = 'c_' . time() . mt_rand(0, 100) . mt_rand(0, 100);

                $query->selectRaw($order['value'] . ' as ' . $columnName);
                $query->orderBy($columnName, $order['direction']);
            } else {
                $query->orderBy($order['value'], $order['direction']);
            }
        }

        if ($limit > 0) {
            $query->limit($limit);
        }

        $queryBuilder->with(['wishes', 'keywords', 'author', 'tags', 'author.feedbacks']);

        return $queryBuilder->get();
    }

    /**
     * @param Swap $swap
     * @return Swap
     */
    public function save(Swap $swap)
    {
        $swap->save();

        return $swap;
    }

    public function saveTags($swap, $tags)
    {
        return $swap->tags()->saveMany($tags);
    }

    public function saveKeywords($swap, $keywords)
    {
        return $swap->keywords()->saveMany($keywords);
    }

    public function saveWishes($swap, $wishes)
    {
        return $swap->wishes()->saveMany($wishes);
    }

    public function findByKeywords($wishKeywords, $keywords)
    {
        $queryBuilder = $this->getQueryBuilder();
        $query = $queryBuilder->getQuery();
        $query->from('swaps')
            ->join('swap_keywords', 'swaps.id', '=', 'swap_keywords.swap_id')
            ->join('keywords', 'keywords.id', '=', 'swap_keywords.keyword_id')
            ->whereIn('keywords.name', $wishKeywords);

        $swapsID = $query->get(['swaps.id']);
        if (count($swapsID) === 0) {
            return [];
        }

        $query = $this->getQueryBuilder()->whereHas('wishes', function ($query) use ($keywords) {
            $query->whereIn('wishes.name', $keywords);
        });

        return $query->with(['wishes', 'author', 'tags'])->get()->all();
    }

    private function getQueryBuilder()
    {
        return clone $this->queryBuilder;
    }
}
