<?php

namespace App\Http\Requests\Tag;

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
            'edit_name' => 'required|string|unique:tags,name,' . $this->route()->id,
            'edit_flag' => 'required|string|unique:tags,flag,' . $this->route()->id,
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
            'edit_name' => '标签名',
            'edit_flag' => '标识',
        ];
    }
}
