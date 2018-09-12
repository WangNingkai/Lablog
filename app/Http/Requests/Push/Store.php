<?php

namespace App\Http\Requests\Push;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'required|string',
            'target' => 'required',
            'method' => 'required',
            'content' => 'required'
        ];
    }

    /**
     * 定义字段名中文
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'subject' => '主题',
            'target' => '用户',
            'method' => '状态',
            'content' => '内容'
        ];
    }
}
