<?php

namespace App\Recommendations\Loaders;

use App\Contracts\Recommendations\LoaderContract;

/**
 * Class CompositeLoader
 * @package App\Recommendations\Loaders
 */
class CompositeLoader implements LoaderContract
{
    /**
     * @var LoaderContract[]
     */
    private $loaders = [];

    /**
     * CompositeLoader constructor.
     * @param \App\Contracts\Recommendations\LoaderContract[] $loaders
     */
    public function __construct(array $loaders)
    {
        $this->loaders = $loaders;
    }

    /**
     * @param array $columns
     * @return \App\Models\Swap[]|null
     */
    public function load(array $columns = ['*'])
    {
        $swaps = [];
        foreach ($this->loaders as $loader) {
            $swaps = array_merge($swaps, $loader->load($columns));
        }

        return $swaps;
    }
}
