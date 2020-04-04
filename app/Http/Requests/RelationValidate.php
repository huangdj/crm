<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RelationValidate extends FormRequest
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
                    'username' => 'required',
                    'user_id' => 'required',
                    'mobile' => 'required|regex:/^1[34578][0-9]{9}$/',
                    'birthday' => 'required',
                    'course_id.*' => 'required',
                    'g_hour.*' => 'required',
                ];
            case 'PUT':
                return [
                    'username' => 'required',
                    'user_id' => 'required',
                    'mobile' => 'required|regex:/^1[34578][0-9]{9}$/',
                    'birthday' => 'required',
                    'course_id.*' => 'required',
                    'g_hour.*' => 'required',
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
            'course_id.*' => '课程',
            'g_hour.*' => '课时',
        ];
    }
}
