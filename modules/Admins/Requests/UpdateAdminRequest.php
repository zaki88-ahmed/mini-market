<?php

namespace modules\Admins\Requests;

use Illuminate\Foundation\Http\FormRequest;
use modules\Admins\Models\Admin;

class UpdateAdminRequest extends FormRequest
{

    public function authorize()
    {
        $request = request();
        return $this->user()->id === $request->admin->id ||$this->user()->can('update_admin', Admin::class);
    }


    public function rules()
    {
        return [
            'name' => 'required|max:255|string',
            'password' => ['required', 'string', 'min:6'],
            'contact' => 'required|min:11|max:14|string',
            'country_id' =>'required|integer|exists:countries,id',
            'city_id' =>'required|integer|exists:cities,id',
            'email' => 'required|string|email'
        ];
    }

    public function messages()
    {
        return [
            'city_id.required' => 'city field is required.',
            'city_id.exists' => 'this city is not identified.',
            'country_id.required' => 'country field is required.',
            'country_id.exists' => 'this country is not identified.',
        ];
    }
}
