<?php

namespace modules\Customers\Requests;

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' =>  'required',
            'email' => 'required|email|unique:vendors,email',
            'password' =>  'required',
        ];
    }



    public function messages()
    {
        return [
            //
            'name' => 'customer name is required',
            'email.required' => 'customer mail is required',
            'email.string' => 'customer must be string',
            'email.exists' => 'customer is not registered',
            'password' => 'customer password is required',
        ];
    }
}
