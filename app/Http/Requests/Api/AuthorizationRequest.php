<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;

class AuthorizationRequest extends FormRequest
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
        $rules = [
            'code'=>'required_without:access_token|string',
            'access_token'=>'required_without:code|string',
        ];
        if ($this->social_type == 'weixin' && !$this->code) {
            //如果是微信且已经是获取用户资料这一步的话,必须要openid
            $rules['openid']='required|string';
        }
        return $rules;
    }
}
