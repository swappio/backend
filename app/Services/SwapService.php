<?php

namespace App\Services;

use App\Contracts\Services\Finders\MatchFinderContract;
use App\Models\Swap;
use App\Contracts\Storages\SwapsStorageContract;

class SwapService
{
    /**
     * @var SwapsStorageContract
     */
    private $storage;

    /**
     * @var TagsService
     */
    private $tagsService;

    /**
     * @var SwapsGraphService
     */
    private $graphService;

    /**
     * @var MatchFinderContract
     */
    private $matcher;

    /**
     * SwapService constructor.
     * @param SwapsStorageContract $storage
     * @param TagsService $tagsService
     * @param SwapsGraphService $graphService
     * @param MatchFinderContract $matcher
     */
    public function __construct(SwapsStorageContract $storage,
                                TagsService $tagsService,
                                SwapsGraphService $graphService,
                                MatchFinderContract $matcher)
    {
        $this->storage = $storage;
        $this->tagsService = $tagsService;
        $this->graphService = $graphService;
        $this->matcher = $matcher;
    }


    public function create($data)
    {
        $swap = new Swap($data);
        if (!$swap->validate($data)) {
            return false;
        }

        $swap = $this->storage->save($swap);
        if (!$swap) {
            return false;
        }

        if (array_key_exists('tags', $data)) {
            $tags = $data['tags'];
            $tags = $this->tagsService->saveAll($tags);
            $this->storage->saveTags($swap, $tags);
        }

        if (array_key_exists('wish', $data)) {
            $wishes = str_replace(',', '', explode(' ', $data['wish']));
            $wishes = $this->tagsService->saveAll($wishes);
            $this->storage->saveWishes($swap, $wishes);
        }

        $this->graphService->add($swap);

        $matches = $this->findMatches($swap);
        foreach ($matches as $match) {
            $this->graphService->connect($swap, $match);
        }

        return $swap;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function loadById($id)
    {
        $swaps = $this->storage->load(['*'], [[
            'column' => 'id',
            'operator' => '=',
            'value' => $id
        ]], [], 1);

        return $swaps->count() > 0 ? $swaps->first() : null;
    }

    public function findMatches(Swap $swap)
    {
        return $this->matcher->find($swap);
    }
}
