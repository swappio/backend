<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait Validatable
{
    public function validate($data)
    {
        $validator = Validator::make($data, $this->rules);
        return $validator->passes();
    }
}
