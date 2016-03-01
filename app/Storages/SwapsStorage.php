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

        $queryBuilder->with(['wishes', 'author', 'tags', 'author.feedbacks']);

        return $queryBuilder->get();
    }

    public function findWithTags($tags)
    {
        $swapTagsCount = $this->getSwapTagsCount($tags);

        $neededSwapIds = [];
        $tagsCount = count($tags);
        foreach ($swapTagsCount as $swapId => $count) {
            if ($count >= $tagsCount) {
                $neededSwapIds[] = $swapId;
            }
        }

        $queryBuilder = $this->getQueryBuilder();

        return $queryBuilder->whereIn('id', $neededSwapIds)
            ->with(['wishes', 'tags', 'author', 'author.feedbacks'])
            ->get();
    }

    public function findWithAnyOfTags($tags)
    {
        $swapTagsCount = $this->getSwapTagsCount($tags);

        uasort($swapTagsCount, function ($a, $b) {
            return $a < $b;
        });

        $neededSwapIds = array_keys($swapTagsCount);

        $queryBuilder = $this->getQueryBuilder();
        $query = $queryBuilder->getQuery();
        $query->orderByRaw('FIELD(id, ' . implode(',', $neededSwapIds) . ')');
        return $queryBuilder->whereIn('id', $neededSwapIds)
            ->with(['wishes', 'tags', 'author', 'author.feedbacks'])
            ->get();
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

    public function saveWishes($swap, $wishes)
    {
        return $swap->wishes()->saveMany($wishes);
    }

    private function getQueryBuilder()
    {
        return clone $this->queryBuilder;
    }

    private function getSwapTagsCount($tags)
    {
        $queryBuilder = $this->getQueryBuilder();
        $query = $queryBuilder->getQuery();
        $query->from('tags')
            ->join('swap_tags', 'tags.id', '=', 'swap_tags.tag_id')
            ->whereIn('tags.name', $tags);

        $rows = $query->get(['swap_tags.swap_id']);
        $swapTagsCount = [];

        foreach ($rows as $row) {
            if (!array_key_exists($row->swap_id, $swapTagsCount)) {
                $swapTagsCount[$row->swap_id] = 0;
            }
            $swapTagsCount[$row->swap_id]++;
        }

        return $swapTagsCount;
    }
}
