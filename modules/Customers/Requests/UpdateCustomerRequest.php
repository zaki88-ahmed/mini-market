<?php

namespace modules\Customers\Requests;

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'email.string' => 'vendor must be string',
            'email.unique' => 'vendor mail is exist',
            'password' => 'vendor password is required',
        ];
    }
}
