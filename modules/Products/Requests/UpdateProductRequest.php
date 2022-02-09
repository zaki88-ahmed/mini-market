<?php


namespace modules\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;
use modules\Admins\Models\Admin;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
//        return $this->user()->can('update', Admin::class);
        return true;
    }

    public function rules()
    {
        return [
            'title'  => 'required|string',
            'price'  => 'required|double',
        ];
    }
    public function messages()
    {

    }

}
