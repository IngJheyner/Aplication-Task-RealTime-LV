<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Rules\Auth\VerificationEmail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    private VerificationEmail $verificationRule;

    public function __construct() {
        parent::__construct();
        $this->verificationRule = new VerificationEmail();
    }

    /**
     * Get the user associated with the email.
     *
     * @return User|null
     */
    public function getUsers(): ?User
    {
        return $this->verificationRule->getUserVerification();
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', $this->verificationRule],
            'password' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email es requerido',
            'email.email' => 'Email no es válido',
            'password.required' => 'Password es requerido',
        ];
    }

    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}
