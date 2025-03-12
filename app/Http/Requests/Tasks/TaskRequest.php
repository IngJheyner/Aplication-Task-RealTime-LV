<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskRequest extends FormRequest
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
            'name' => 'required',
            'project_id' => 'required|numeric',
            'member_ids' => 'required|array',
            'member_ids.*' => 'numeric',
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
            'name.required' => 'El nombre de la tarea es requerido',
            'project_id.required' => 'El id del proyecto es requerido',
            'member_ids.required' => 'Los miembros son requeridos',
            'member_ids.array' => 'Los miembros deben ser un array',
            'member_ids.*.numeric' => 'Cada miembro debe ser un numero',
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
