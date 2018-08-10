<?php

namespace App\Http\Requests\Page;

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'author' => 'required|string',
            'content' => 'required|string',
            'status' => 'required'
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
            'title' => '标题',
            'author' => '作者',
            'content' => '内容',
            'status' => '状态'
        ];
    }
}
