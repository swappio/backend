<?php

namespace App\Contracts\Recommendations;

use App\Models\Swap;

/**
 * Interface LoaderContract
 * @package App\Contracts\Recommendations
 */
interface LoaderContract
{
    /**
     * @param array $columns
     * @return Swap[]
     */
    public function load(array $columns = ['*']);
}
