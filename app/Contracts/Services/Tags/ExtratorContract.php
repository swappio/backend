<?php

namespace App\Contracts\Services\Tags;

use App\Models\Swap;

/**
 * Interface ExtratorContract
 * @package App\Contracts\Services\Tags
 */
interface ExtratorContract
{
    /**
     * @param Swap $swap
     * @return string[]
     */
    public function extract(Swap $swap);
}
