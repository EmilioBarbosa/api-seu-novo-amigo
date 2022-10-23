<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;

class UserCanOnlyUpdateHimself implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private User $user, private string $user_token)
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $token = PersonalAccessToken::findToken($this->user_token);
        if ($this->user->id === $token->tokenable_id ){
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Não autorizado';
    }
}
