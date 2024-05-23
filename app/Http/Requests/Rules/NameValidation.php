<?php

namespace App\Http\Requests\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class NameValidation implements Rule
{
    public function passes($attribute, $value)
    {
        return !Str::startsWith($value, 'syu_');
    }

    public function message()
    {
        return 'Your name must be a real name.';
    }
}
