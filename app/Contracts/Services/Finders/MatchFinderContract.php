<?php

namespace App\Contracts\Services\Finders;

use App\Models\Swap;

/**
 * Interface MatchFinderContract
 * @package App\Contracts\Services\Finders
 */
interface MatchFinderContract
{
    /**
     * @param Swap $swap
     * @return Swap[]
     */
    public function find(Swap $swap);
}
