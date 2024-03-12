<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MobileNumberRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!preg_match('/^01[3-9]\d{8}$/u', $value)){
            $fail('The :attribute must be valid mobile number.');
        }
    }
}
