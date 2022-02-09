<?php

namespace modules\Categories\Request;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategory extends FormRequest
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
            "id" => 'exists:categories,id',
            "name" => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'id' => 'Category Id Exist',
            'name.required' => 'Category Name Required',
            'name.string' => 'Category Name Must Be String',
        ];
    }
}
