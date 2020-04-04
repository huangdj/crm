<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerValidate extends FormRequest
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
                    'username' => 'required|max:255',
                    'user_id' => 'required',
                    'mobile' => 'required|unique:customers|regex:/^1[34578][0-9]{9}$/',
                    'birthday' => 'required',
                ];
            case 'PUT':
                return [
                    'username' => 'required|max:255',
                    'user_id' => 'required',
                    'mobile' => 'required|unique:customers,mobile,' . $this->route('customers') . '|regex:/^1[34578][0-9]{9}$/',
                    'birthday' => 'required',
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
            'username' => '会员姓名',
            'user_id' => '教练',
            'mobile' => '手机号合法且',
            'birthday' => '生日',
        ];
    }
}
