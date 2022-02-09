<?php

namespace  modules\Roles\Request;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'required|string|unique:roles,name'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Role Name Required',
            'name.string' => 'Role Name Must Be String',
            'name.unique' => 'Role Already Exists'
        ];
    }
}
