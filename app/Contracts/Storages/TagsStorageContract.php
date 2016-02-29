<?php

namespace App\Contracts\Storages;

/**
 * Interface TagsStorageContract
 * @package App\Contracts\Storages
 */
interface TagsStorageContract
{

    /**
     * @param string[] $tagNames
     * @return \App\Models\Tag[]
     */
    public function findAll($tagNames);

    /**
     * @param \App\Models\Tag[] $tags
     * @return \App\Models\Tag[]
     */
    public function saveAll($tags);
}
