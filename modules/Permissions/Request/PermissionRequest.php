<?php

namespace modules\Permissions\Request;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'name' => 'required|string|unique:permissions,name'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Permission Name Required',
            'name.string' => 'Permission Name Must Be String',
            'name.unique' => 'Permission Already Exists'
        ];
    }
}
