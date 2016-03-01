<?php

namespace App\Services\Finders\Matches;

use App\Contracts\Services\Finders\MatchFinderContract;
use App\Contracts\Storages\SwapsStorageContract;

class ExactMatchFinder extends AbstractMatchFinder implements MatchFinderContract
{
    /**
     * @var SwapsStorageContract
     */
    private $storage;

    /**
     * ExactMatchFinder constructor.
     * @param SwapsStorageContract $storage
     */
    public function __construct(SwapsStorageContract $storage)
    {
        $this->storage = $storage;
    }

    protected function getData($tags)
    {
        return $this->storage->findWithTags($tags);
    }

    protected function isMatched($foundTags, $tags)
    {
        foreach ($foundTags as $foundTag) {
            if (!in_array($foundTag->name, $tags, true)) {
                return false;
            }
        }

        return true;
    }
}
