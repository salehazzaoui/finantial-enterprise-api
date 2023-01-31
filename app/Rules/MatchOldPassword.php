<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\Hash;

class MatchOldPassword implements InvokableRule
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
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
        if (!Hash::check($value, $this->user->password)) {
            $fail('validation.old_password_incorrect')->translate();
        }
    }
}
