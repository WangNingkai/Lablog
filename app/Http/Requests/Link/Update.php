<?php

namespace App\Http\Requests\Link;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    /**
     * 判断用户是否有权限进行此请求。
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
            'edit_name' => 'required|string|unique:links,name,' . $this->id,
            'edit_url' => 'required|url|unique:links,url,' . $this->id,
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
            'edit_name' => '友链名称',
            'edit_url' => '链接地址',

        ];
    }
}
