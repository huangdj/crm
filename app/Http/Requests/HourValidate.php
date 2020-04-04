<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HourValidate extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'c_name' => 'required',
                    'price' => 'required|numeric',
                ];
            case 'PUT':
                return [
                    'c_name' => 'required',
                    'price' => 'required|numeric',
                ];
        }
    }

    /***
     * 定义字段名称
     * @return array
     */
    public function attributes()
    {
        return [
            'c_name' => '课时名称',
            'price' => '课时单价',
        ];
    }
}
