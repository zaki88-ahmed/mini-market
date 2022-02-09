<?php

namespace modules\Customers\Requests;

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use modules\Customers\Rules\MatchOldPassword;

class UpdatePasswordRequest extends FormRequest
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
            'old_password' => ['required', new MatchOldPassword],
            'new_password' =>  'required',
        ];
    }



    public function messages()
    {
        return [
            //
            'old_password.required' =>'old password is required',
            'old_password' => 'old password is wrong',
            'new_password.required' =>'new password is required',

        ];
    }
}
