<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SecurePassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Password must have at least one uppercase letter, one lowercase letter,
        // one digit, one special character, and a minimum length of 8 characters.
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/';

        if (!preg_match($pattern, $value)) {
            $fail(__("The {$attribute} must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one digit, and one special character."));
        }
    }
}
