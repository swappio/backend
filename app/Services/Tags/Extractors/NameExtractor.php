<?php

namespace App\Services\Tags\Extractors;

use App\Contracts\Services\Tags\ExtractorContract;
use App\Models\Swap;

class NameExtractor implements ExtractorContract
{
    public function extract(Swap $swap)
    {
        $extracted = explode(' ', $swap->name);

        $extracted = array_filter($extracted, function ($item) {
            return strlen($item) >= 3;
        });

        return array_map(function ($item) {
            return strtolower($item);
        }, $extracted);
    }
}
