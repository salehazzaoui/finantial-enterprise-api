<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class TypeTransactionRule implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if ($value !== "MINUS") {
            if ($value !== "ADD") {
                $fail('validation.transaction_type')->translate();
            }
        }
    }
}
