<?php

namespace  modules\Categories\Request;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => 'required|string|unique:categories,name',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Category Name Required',
            'name.string' => 'Category Name Must Be String',
            'name.unique' => 'Category Already Exists',
        ];
    }
}
