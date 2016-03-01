<?php

namespace App\Service\Tags\Extractors;

use App\Contracts\Services\Tags\ExtratorContract;
use App\Models\Swap;

class NameExtrator implements ExtratorContract
{
    public function extract(Swap $swap)
    {
        return explode(' ', $swap->name);
    }
}
