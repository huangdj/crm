<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordValidate extends FormRequest
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
        return [
            'buy_course_id' => 'required_without_all:relation_course_id',
            'relation_course_id' => 'required_without_all:buy_course_id',
        ];
    }

    /***
     * 定义字段名称
     * @return array
     */
    public function attributes()
    {
        return [
            'buy_course_id' => '购课课程',
            'relation_course_id' => '赠课课程',
        ];
    }
}
