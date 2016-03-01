<?php

namespace App\Services\Tags\Extractors;

use App\Contracts\Services\Tags\ExtractorContract;
use App\Models\Swap;

class CompositeExtractor implements ExtractorContract
{
    /**
     * @var ExtractorContract[]
     */
    private $extractors = [];

    /**
     * CompositeExtrator constructor.
     * @param \App\Contracts\Services\Tags\ExtractorContract[] $extractors
     */
    public function __construct(array $extractors)
    {
        $this->extractors = $extractors;
    }


    public function extract(Swap $swap)
    {
        $tags = [];

        foreach ($this->extractors as $extractor) {
            $tags = array_merge($tags, $extractor->extract($swap));
        }

        return $tags;
    }
}
