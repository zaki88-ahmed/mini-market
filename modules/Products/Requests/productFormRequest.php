<?php

namespace modules\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;
use modules\Customers\Rules\MatchOldPassword;

class productFormRequest extends FormRequest
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

        return $this->getProductRules($this->input('class'));
    }



    public function getProductRules($class)
    {
        $rules = [];
        switch($class){

            case "createProduct":
                $rules = [
                    'title'  => 'required|string',
                    'price'  => 'required|numeric',
                ];
                break;

            case "updateProduct":
                $rules = [
                    'product_id' =>  'required|exists:products,id',
                    'title'  => 'required|string',
                    'price'  => 'required|numeric',
                ];
                break;

            case "showProduct":
                $rules = [
                    'product_id' =>  'required|exists:products,id',
                ];
                break;

            case "softDeleteProduct":
                $rules = [
                    'product_id' =>  'required|exists:products,id',
                ];
                break;

            case "restoreProduct":
                $rules = [
                    'product_id' =>  'required|exists:products,id',
                ];
                break;

        }
        return $rules;
    }
}
