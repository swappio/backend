<?php

namespace App\Service\Tags\Extractors;

use App\Contracts\Services\Tags\ExtratorContract;
use App\Models\Swap;

class CompositeExtrator implements ExtratorContract
{
    /**
     * @var ExtratorContract[]
     */
    private $extractors = [];

    /**
     * CompositeExtrator constructor.
     * @param \App\Contracts\Services\Tags\ExtratorContract[] $extractors
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
