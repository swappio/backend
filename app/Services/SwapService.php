<?php

namespace App\Services;

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
     * @var KeywordsService
     */
    private $keywordsService;

    /**
     * @var WishService
     */
    private $wishService;

    /**
     * @var SwapsGraphService
     */
    private $graphService;

    /**
     * SwapService constructor.
     * @param SwapsStorageContract $storage
     * @param TagsService $tagsService
     * @param KeywordsService $keywordsService
     * @param WishService $wishService
     * @param SwapsGraphService $graphService
     */
    public function __construct(SwapsStorageContract $storage,
                                TagsService $tagsService,
                                KeywordsService $keywordsService,
                                WishService $wishService,
                                SwapsGraphService $graphService)
    {
        $this->storage = $storage;
        $this->tagsService = $tagsService;
        $this->keywordsService = $keywordsService;
        $this->wishService = $wishService;
        $this->graphService = $graphService;
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

        $keywords = $this->keywordsService->saveAll($swap);
        $this->storage->saveKeywords($swap, $keywords);

        if (array_key_exists('wish', $data)) {
            $wishes = str_replace(',', '', explode(' ', $data['wish']));
            $wishes = $this->wishService->saveAll($wishes);
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

        return !empty($swaps) ? $swaps[0] : null;
    }

    public function findMatches(Swap $swap)
    {
        $wishes = $swap->wishes->getDictionary();
        $wishKeywords = array_map(function ($wish) {
            return $wish->name;
        }, $wishes);

        $keywords = $swap->keywords->getDictionary();
        $keywords = array_map(function ($keyword) {
            return $keyword->name;
        }, $keywords);

        return $this->storage->findByKeywords($wishKeywords, $keywords);
    }
}
