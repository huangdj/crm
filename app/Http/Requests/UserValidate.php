<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserValidate extends FormRequest
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
                    'master_no' => 'required',
                    'name' => 'required|max:8',
                    'realname' => 'required',
                    'base_salary' => 'required|numeric',
                    'task' => 'required|numeric',
                ];
            case 'PUT':
                return [
                    'master_no' => 'required',
                    'realname' => 'required',
                    'base_salary' => 'required|numeric',
                    'task' => 'required|numeric',
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
            'master_no' => '教练工号',
            'name' => '登录账号',
            'realname' => '真实姓名',
            'base_salary' => '底薪',
            'task' => '业务指标',
        ];
    }
}
