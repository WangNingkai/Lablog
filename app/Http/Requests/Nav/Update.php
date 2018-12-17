<?php

namespace App\Http\Requests\Nav;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
            'name'      => 'required|string|unique:navs,name,'
                .$this->route()->id,
            'type'      => 'required',
            'parent_id' => 'required',
            'sort'      => 'required',
            'status'    => 'required',
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
            'name'      => '菜单名',
            'type'      => '菜单类型',
            'parent_id' => '父级ID',
            'sort'      => '排序权重',
            'status'    => '状态',
        ];
    }
}
