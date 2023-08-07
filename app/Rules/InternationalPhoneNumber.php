<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class InternationalPhoneNumber implements ValidationRule
{
    protected bool $isRequired;

    /**
     * InternationalPhoneNumber constructor.
     *
     * @param bool $isRequired
     * @return void
     */
    public function __construct(bool $isRequired = true)
    {
        $this->isRequired = $isRequired;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($this->isRequired) {
            $pattern = '/^\+[1-9]\d{1,14}$/';
            if (!preg_match($pattern, $value)) {
                $fail(__("The {$attribute} must be a valid international phone number in the format +1234567890."));
            }
        }

    }
}
