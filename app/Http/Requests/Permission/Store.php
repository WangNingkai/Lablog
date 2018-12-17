<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
            'name'  => 'required|string|unique:permissions',
            'route' => 'required|string|unique:permissions',
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
            'name'  => '权限名',
            'route' => '路由名',

        ];
    }
}
