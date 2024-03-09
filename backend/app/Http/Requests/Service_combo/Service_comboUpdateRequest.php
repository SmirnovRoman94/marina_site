<?php

namespace App\Http\Requests\Service_combo;

use Illuminate\Foundation\Http\FormRequest;

class Service_comboUpdateRequest extends FormRequest
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
            'id' => 'integer|exists:service_combos,id',
            'title' => 'string|required',
            'old_price' => 'integer|required',
            'discount' => 'integer|required',
            'count_level' => 'integer|required',
            'services' => 'array|required',
            'img' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле name необходимо для заполнения',
            'price.required' => 'Поле old_price необходимо для заполнения',
            'discount.required' => 'Поле discount необходимо для заполнения',
            'count_level.required' => 'Поле count_level необходимо для заполнения',
            'services.required' => 'Поле services необходимо для заполнения',
            'img|image' => 'Файл должен быть картинкой (.png, .jpeg, .img)'
        ];
    }
}
