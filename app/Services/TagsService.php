<?php

namespace App\Services;

use App\Contracts\Storages\TagsStorageContract;
use App\Models\Tag;

/**
 * Class TagsService
 * @package App\Services
 */
class TagsService
{
    /**
     * @var TagsStorageContract
     */
    private $storage;

    /**
     * TagsService constructor.
     * @param TagsStorageContract $storage
     */
    public function __construct(TagsStorageContract $storage)
    {
        $this->storage = $storage;
    }


    /**
     * Saves all tags
     *
     * @param string[] $tags
     * @return array
     */
    public function saveAll($tags)
    {
        $foundTags = $this->storage->findAll($tags);
        $notFoundTags = array_filter($tags, function ($tag) use ($foundTags) {
            foreach ($foundTags as $foundTag) {
                if ($tag === $foundTag->name) {
                    return false;
                }
            }

            return true;
        });

        $modelsToSave = [];
        foreach ($notFoundTags as $tag) {
            $modelsToSave[] = new Tag(['name' => $tag]);
        }

        $tags = $this->storage->saveAll($modelsToSave);

        return array_merge($foundTags ?: [], $tags);
    }
}
