<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KpiValidate extends FormRequest
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
            case 'PUT':
                return [
                    'start.*' => 'required',
                    'end.*' => 'required',
                    'percent.*' => 'required',
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
            'start.*' => '开始值',
            'end.*' => '结束值',
            'percent.*' => '百分比',
        ];
    }
}
