<?php

namespace App\Services\Finders\Matches;

use App\Contracts\Services\Finders\MatchFinderContract;
use App\Models\Swap;

abstract class AbstractMatchFinder implements MatchFinderContract
{
    /**
     * @param array
     * @return Swap[]
     */
    abstract protected function getData($tags);

    /**
     * @param $foundTags
     * @param $tags
     * @return boolean
     */
    abstract protected function isMatched($foundTags, $tags);

    public function find(Swap $swap)
    {
        $wishes = array_map(function ($tag) {
            return $tag->name;
        }, $swap->wishes->getDictionary());

        $foundSwaps = $this->getData($wishes);

        $matches = [];

        $tags = array_map(function ($tag) {
            return $tag->name;
        }, $swap->tags->getDictionary());

        foreach ($foundSwaps as $foundSwap) {
            $foundTags = $foundSwap->wishes->getDictionary();

            if ($this->isMatched($foundTags, $tags)) {
                $matches[] = $foundSwap;
            }
        }

        return $matches;
    }
}
