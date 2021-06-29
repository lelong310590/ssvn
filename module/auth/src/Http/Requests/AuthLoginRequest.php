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
            'email' => 'email|required',
			'password' => 'required'
		];
	}
	
	public function messages()
	{
		return [
			'email.required' => 'Tên đăng nhập không được bỏ trống',
			'password.required' => 'Mật khẩu không được bỏ trống',
            'email.email'=>'Email sai định dạng',
		];
	}
}