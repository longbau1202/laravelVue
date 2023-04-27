<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $categoryId = $this->route('id');
        return [
            'category_name' => ['required', 'string', 'max:255', Rule::unique('categories', 'category_name')->ignore($categoryId)],
            'category_code' => ['required', 'string', 'min:6'],
            'category_description' => ['required', 'string', 'min:6'],
        ];
    }
}
