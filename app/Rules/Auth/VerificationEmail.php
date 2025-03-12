<?php

namespace App\Rules\Auth;

use App\Events\NewUserCreated;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class VerificationEmail implements ValidationRule
{
    private ?User $user = null;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->user = User::where('email', $value)->first();

        if (!is_null($this->user) && intval($this->user->is_valid_email) !== User::IS_VALID_EMAIL) {

            NewUserCreated::dispatch($this->user);
            $fail('Hemos enviado un correo de validación a su email. Por favor, valide su email para poder ingresar.');

        }
    }

    /**
     * Get the user verification.
     *
     * @return User|null
     */
    public function getUserVerification(): ?User {
        return $this->user;
    }
}
