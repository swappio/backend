<?php

namespace App\Contracts\Storages;

/**
 * Interface KeywordsStorageContract
 * @package App\Contracts\Storages
 */
interface KeywordsStorageContract
{

    /**
     * @param string[] $keywordNames
     * @return \App\Models\Keyword[]
     */
    public function findAll($keywordNames);

    /**
     * @param \App\Models\Keyword[] $keywords
     * @return \App\Models\Keyword[]
     */
    public function saveAll($keywords);
}
