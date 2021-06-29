<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 10:47 PM
 */

namespace Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required',
            'email' => 'email|required|min:5|unique:users,email',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Tên không được bỏ trống',
            'email.required' => 'Email không được bỏ trống',
            'email.min' => 'Độ dài tối thiểu cho tên đăng nhập là 5 ký tự',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'email.email' => 'Email sai định dạng',
            'name.required' => 'Tên đăng nhập không được bỏ trống',
            'email.unique' => 'Email đã tồn tại'
        ];
    }
}