<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
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
            'title' => 'string|required',
            'description' => 'string|required',
            'price' => 'integer|required',
            'form' => 'string|required',
            'duration' => 'integer|required',
            'preview' => 'string|required',
            'img' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле title необходимо для заполнения',
            'description.required' => 'Поле description необходимо для заполнения',
            'form.required' => 'Поле form необходимо для заполнения',
            'preview.required' => 'Поле preview необходимо для заполнения',
            'price.required' => 'Поле price необходимо для заполнения',
            'price.integer' => 'Поле price должен быть числовым значением',
            'duration.required' => 'Поле duration необходимо для заполнения',
            'duration.integer' => 'Поле duration должен быть числовым значением',
        ];
    }
}
