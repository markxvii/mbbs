<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'=>'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,'.\Auth::id(),
            'email'=>'required|email|unique:users,email,'.\Auth::id(),
            'introduction'=>'max:80',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200',
        ];
    }

    public function messages()
    {
        return [
            'avatar.mimes' => '头像必须是jpeg,bmp,png,gif格式的图片',
            'avatar.dimensions' => '图片清晰度不够，宽高请保持200px以上'
        ];
    }

    public function attributes()
    {
        return [
            'name' => '用户名',
            'email' => '邮箱',
            'introduction'=>'个人简介'
        ];
    }
}
