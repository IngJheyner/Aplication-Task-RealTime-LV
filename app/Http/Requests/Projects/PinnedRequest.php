<?php

namespace App\Http\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PinnedRequest extends FormRequest
{
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
            'project_id' => 'required|exists:task_progress,project_id|numeric'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() : array
    {
        return [
            'project_id.required' => 'El campo project_id es obligatorio.',
            'project_id.exists' => 'El campo project_id no existe en la tabla task_progress.',
            'project_id.numeric' => 'El campo project_id debe ser un número.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            "errors" => $validator->errors()->all()
        ], 422));
    }
}
