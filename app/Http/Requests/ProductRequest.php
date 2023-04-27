<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $productId = $this->route('id');
        return [
            'product_name' => ['required', 'string', 'max:255', Rule::unique('products', 'product_name')->ignore($productId)],
            'product_brand' => ['required'],
            'product_price' => ['required', 'numeric', 'min:6'],
            'product_description' => ['required', 'string', 'min:6'],
        ];
    }
}
