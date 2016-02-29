<?php

namespace App\Services;

use App\Models\Keyword;
use App\Contracts\Storages\KeywordsStorageContract;
use App\Models\Swap;

class KeywordsService
{
    /**
     * @var KeywordsStorageContract
     */
    private $storage;

    /**
     * KeywordsService constructor.
     * @param KeywordsStorageContract $storage
     */
    public function __construct(KeywordsStorageContract $storage)
    {
        $this->storage = $storage;
    }


    /**
     * Saves all keywords
     *
     * @param Swap $swap
     * @return array
     */
    public function saveAll($swap)
    {
        $keywords = explode(' ', $swap->name);

        $foundKeywords = $this->storage->findAll($keywords);
        $notFoundKeywords = array_filter($keywords, function ($keyword) use ($foundKeywords) {
            foreach ($foundKeywords as $foundTag) {
                if ($keyword === $foundTag->name) {
                    return false;
                }
            }

            return true;
        });

        $modelsToSave = [];
        foreach ($notFoundKeywords as $keyword) {
            $modelsToSave[] = new Keyword(['name' => $keyword]);
        }

        $keywords = $this->storage->saveAll($modelsToSave);

        return array_merge($foundKeywords, $keywords);
    }
}
