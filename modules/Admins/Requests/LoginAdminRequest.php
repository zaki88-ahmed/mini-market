<?php


namespace modules\Admins\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password' => ['required', 'string'],
            'email' => 'required|string|email|exists:admins'
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'not an Email format.',
            'email.exists' => 'Email not registered'
        ];
    }

}
