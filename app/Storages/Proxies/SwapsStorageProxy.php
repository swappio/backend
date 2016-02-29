<?php

namespace App\Storages\Proxies;

use App\Contracts\Storages\SwapsStorageContract;
use App\Models\Swap;
use Illuminate\Cache\Repository;

class SwapsStorageProxy implements SwapsStorageContract
{
    /**
     * @var SwapsStorageContract
     */
    private $swapsStorage;

    /**
     * @var Repository
     */
    private $cache;

    /**
     * SwapsStorageProxy constructor.
     * @param SwapsStorageContract $swapsStorage
     * @param Repository $cache
     */
    public function __construct(SwapsStorageContract $swapsStorage, Repository $cache)
    {
        $this->swapsStorage = $swapsStorage;
        $this->cache = $cache;
    }


    public function load(array $columns = ['*'], array $conditions = [], array $orders = [], $limit = 0)
    {
        $key = 'swaps_' . sha1(serialize($columns) . serialize($conditions) . serialize($orders) . $limit);

        if ($this->cache->tags(['swaps'])->has($key)) {
            return $this->cache->tags(['swaps'])->get($key);
        }

        $data = $this->swapsStorage->load($columns, $conditions, $orders, $limit);
        $this->cache->tags(['swaps'])->put($key, $data, 24 * 60);

        return $data;
    }

    public function save(Swap $swap)
    {
        $this->cache->tags(['swaps'])->flush();

        return $this->swapsStorage->save($swap);
    }

    public function saveTags($swap, $tags)
    {
        $this->cache->tags(['swaps'])->flush();

        return $this->swapsStorage->saveTags($swap, $tags);
    }

    public function saveKeywords($swap, $keywords)
    {
        $this->cache->tags(['swaps'])->flush();

        return $this->swapsStorage->saveKeywords($swap, $keywords);
    }

    public function saveWishes($swap, $wishes)
    {
        $this->cache->tags(['swaps'])->flush();

        return $this->swapsStorage->saveWishes($swap, $wishes);
    }

    public function findByKeywords($wishKeywords, $keywords)
    {
        $key = 'swaps_by_keywords' . sha1(serialize($wishKeywords) . serialize($keywords));

        if ($this->cache->tags(['swaps'])->has($key)) {
            return $this->cache->tags(['swaps'])->get($key);
        }

        $data = $this->swapsStorage->findByKeywords($wishKeywords, $keywords);
        $this->cache->tags(['swaps'])->put($key, $data, 24 * 60);

        return $data;
    }
}
