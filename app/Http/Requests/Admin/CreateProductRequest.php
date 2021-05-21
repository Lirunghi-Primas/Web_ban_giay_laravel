<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $this->merge([
            'is_pinned' => (bool) $this->is_pinned
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:products,title',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|regex:/^[0-9]+$/',
            'cost' => 'sometimes|nullable|regex:/^[0-9]+$/|gte:price',
            'thumbnail' => 'sometimes|nullable|image',
            'description' => 'sometimes|nullable|string',
            'is_pinned' => 'required|boolean'
        ];
    }
}
