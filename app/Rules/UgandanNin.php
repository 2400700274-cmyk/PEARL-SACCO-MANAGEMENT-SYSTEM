<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class UgandanNin implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value)) {
            $fail('The '.$attribute.' must be a valid string.');

            return;
        }

        $clean = strtoupper(preg_replace('/\s+/', '', $value));

        if (strlen($clean) !== 14) {
            $fail('The '.$attribute.' must be exactly 14 characters long according to Uganda NIRA guidelines.');

            return;
        }

        // Must start with 2 uppercase letters followed by 12 alphanumeric characters
        // Standard Uganda NIRA NINs start with CM (Citizen Male) or CF (Citizen Female), or other valid residency prefix
        if (! preg_match('/^[A-Z]{2}[0-9A-Z]{12}$/', $clean)) {
            $fail('The '.$attribute.' format is invalid. Uganda NINs must start with 2 letters followed by 12 alphanumeric characters (e.g., CM90012345ABCD or CF92012345ABCD).');
        }
    }
}
