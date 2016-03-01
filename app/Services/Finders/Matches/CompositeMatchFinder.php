<?php

namespace App\Services\Finders\Matches;

use App\Contracts\Services\Finders\MatchFinderContract;
use App\Models\Swap;

class CompositeMatchFinder implements MatchFinderContract
{
    /**
     * @var MatchFinderContract[]
     */
    private $finders = [];

    /**
     * CompositeMatchFinder constructor.
     * @param \App\Contracts\Services\Finders\MatchFinderContract[] $finders
     */
    public function __construct(array $finders)
    {
        $this->finders = $finders;
    }


    public function find(Swap $swap)
    {
        $matches = [];

        foreach ($this->finders as $finder) {
            $finderMatches = $finder->find($swap);
            if (count($finderMatches) !== 0) {
                return $finderMatches;
            }
        }

        return $matches;
    }
}
