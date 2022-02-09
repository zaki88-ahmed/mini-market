<?php

namespace modules\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;
use modules\Admins\Models\Admin;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('store', Admin::class);
    }

    public function rules()
    {
        return [
            'title'  => 'required|string',
            'price'  => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [

        ];
    }

}
