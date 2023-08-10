<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidDeliveryDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $next48Hours = Carbon::now()->addHours(48);

        if (Carbon::parse($value)->lessThan($next48Hours)) {
            $fail('The :attribute must be beyond 48 hours.');
        }
    }
}
