<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 10:47 PM
 */

namespace Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
            'citizen_identification' => 'required|min:9|max:12',
			'password' => 'required'
		];
	}
	
	public function messages()
	{
		return [
            'citizen_identification.required' => 'Số CCCD/CMND không được bỏ trống',
            'citizen_identification.min' => 'Số CMND/CCCD không hợp lệ',
            'citizen_identification.max' => 'Số CMND/CCCD không hợp lệ',
            'password.required' => 'Mật khẩu không được bỏ trống',
        ];
	}
}