<?php

namespace App\Http\Requests\Category;

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
            'name' => 'required|string|unique:categories,name,' . $this->route()->id,
            'flag' => 'required|string|unique:categories,flag,' . $this->route()->id,
            'keywords' => 'required|string',
            'description' => 'required|string',
            'pid' => 'required',
            'sort' => 'required',
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
            'name' => '栏目名',
            'flag' => '标识',
            'keywords' => '关键字',
            'description' => '描述',
            'pid' => '父级ID',
            'sort' => '排序权重',
        ];
    }
}
