<?php

namespace modules\Customers\Requests;

use Illuminate\Foundation\Http\FormRequest;
use modules\Customers\Rules\MatchOldPassword;

class CustomerFormRequest extends FormRequest
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

            return $this->getCustomerRules($this->input('class'));

    }



    public function getCustomerRules($class)
    {
        $rules = [];
        switch($class){
            case "register":
                $rules = [
                    'name' =>  'required',
                    'email' => 'required|email|unique:customers,email',
                    'password' =>  'required',
                ];
                break;
            case "login":
                $rules = [
                    'email' => 'required|email|exists:customers,email',
                    'password' =>  'required',
                ];
                break;
            case "updatePassword":
                $rules = [
                    'old_password' => ['required', new MatchOldPassword],
                    'new_password' =>  'required',
                ];

            case "updateCustomer":
                $rules = [
                    'name' =>  'required',
                    'email' => 'required|email|unique:customers,email',
                    'password' =>  'required',
                ];
                break;
            case "softDeleteCustomer":
                $rules = [
                    'customer_id' => 'required|exists:customers,id'
                ];
                break;
            case "restoreCustomer":
                $rules = [
                    'customer_id' => 'required|exists:customers,id'
                ];
                break;

        }
        return $rules;
    }
}
