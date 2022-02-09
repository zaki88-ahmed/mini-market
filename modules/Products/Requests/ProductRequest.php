<?php


namespace modules\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $request = request();
        $method = $request->method();
        $rules = [];
        switch ($method) {
            case 'POST':
            case 'PUT':
                $rules += [
                        'title'  => 'required|string',
                        'price'  => 'required|numeric',
                    ];
                break;
        }

        return $rules;
    }

    public function messages()
    {
    }

}
