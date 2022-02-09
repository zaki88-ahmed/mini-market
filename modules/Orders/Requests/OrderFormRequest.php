<?php

namespace modules\Orders\Requests;

use Illuminate\Foundation\Http\FormRequest;
use modules\Customers\Rules\MatchOldPassword;

class OrderFormRequest extends FormRequest
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

        return $this->getOrderRules($this->input('class'));
    }



    public function getOrderRules($class)
    {
        $rules = [];
        switch($class){

            case "createOrder":
                $rules = [
                    'status' => 'required|tinyInteger',
                    'shipping' =>  'required|double',
                    'total' =>  'required|double',
                    'customer_id' => 'required|exists:orders,id',
                    'payment_id' =>  'required|exists:payments,id',
                ];
                break;

            case "updateOrder":
                $rules = [
                    'order_id' =>  'required|exists:orders,id',
                    'status' => 'required|tinyInteger',
                    'shipping' =>  'required|double',
                    'total' =>  'required|double',
                    'customer_id' => 'required|exists:orders,id',
                    'payment_id' =>  'required|exists:payments,id',
                ];
                break;

            case "showOrder":
                $rules = [
                    'order_id' => 'required|exists:orders,id'
                ];
                break;

            case "softDeleteOrder":
                $rules = [
                    'order_id' => 'required|exists:orders,id'
                ];
                break;

            case "restoreOrder":
                $rules = [
                    'order_id' => 'required|exists:orders,id'
                ];
                break;

        }
        return $rules;
    }
}
