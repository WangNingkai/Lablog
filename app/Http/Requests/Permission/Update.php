<?php

namespace App\Http\Requests\Permission;

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
            'edit_name' => 'required|string|unique:permissions,name,' . $this->route()->id,
            'edit_route' => 'required|string|unique:permissions,route,' . $this->route()->id,
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
            'edit_name' => '权限名',
            'edit_route' => '路由名',

        ];
    }
}
