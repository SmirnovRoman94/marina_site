<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientStoreRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'form' => 'required',
            'diagnosis' => 'nullable|string',
            'comments' => 'nullable|string',
            'products' => 'nullable|string',
            'services' => 'nullable|string',
            'service_combo' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Поле user_id необходимо для заполнения',
            'user_id.exists' => 'Данный пользователь не найден',
            'diagnosis.required' => 'Поле diagnosis необходимо для заполнения',
            'comments.required' => 'Поле diagnosis необходимо для заполнения',
        ];
    }
}
