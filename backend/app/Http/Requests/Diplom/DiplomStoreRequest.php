<?php

namespace App\Http\Requests\Diplom;

use Illuminate\Foundation\Http\FormRequest;

class DiplomStoreRequest extends FormRequest
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
            'img' => 'nullable|image'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле title необходимо для заполнения',
            'img|image' => 'Файл должен быть картинкой (.png, .jpeg, .img)'
        ];
    }
}
