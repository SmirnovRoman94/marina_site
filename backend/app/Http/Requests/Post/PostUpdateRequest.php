<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
            'text' => 'string|required',
            'preview' => 'string|required',
            'img' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле title необходимо для заполнения',
            'text.required' => 'Поле text необходимо для заполнения',
            'preview.required' => 'Поле preview необходимо для заполнения'
        ];
    }
}
