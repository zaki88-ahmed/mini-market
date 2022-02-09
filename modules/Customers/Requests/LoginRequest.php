<?php

namespace modules\Customers\Requests;

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            //
            'email' => 'required|email|exists:vendors,email',
            'password' =>  'required',
        ];
    }



    public function messages()
    {
        return [
            //
            'email.required' => 'vendor mail is required',
            'email.string' => 'vendor must be string',
            'email.exists' => 'vendor is not registered',
            'password' => 'vendor password is required',
        ];
    }
}
