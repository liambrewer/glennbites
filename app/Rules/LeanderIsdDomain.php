<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LeanderIsdDomain implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        list($_, $domain) = explode('@', $value);

        if ($domain !== 'leanderisd.org' && $domain !== 'k12.leanderisd.org') {
            $fail('You must use your school email address.');
        }
    }
}
