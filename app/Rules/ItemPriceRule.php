<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ItemPriceRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = "/^\d+(\.\d{1,2})?$/";
        if (!preg_match($pattern, $value)){
            $fail(__("Kindly provide a valid price for the item. (e.g 300.89)"));
        }
    }
}
