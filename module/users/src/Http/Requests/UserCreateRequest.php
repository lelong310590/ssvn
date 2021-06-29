<?php

namespace Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
	        'email' => 'required|email|unique:users,email',
	        'password' => 'required|min:6',
	        're_password' => 'required|same:password',
	        'first_name' => 'required',
	        'last_name' => 'required'
        ];
    }
	
	/**
	 * @return array
	 */
    public function messages()
    {
	    return [
		    'email.required' => 'Email không được bỏ trống',
		    'email.email' => 'Định dạng Email không đúng',
		    'email.unique' => 'Email này đã được sử dụng',
		    'password.required' => 'Mật khẩu không được bỏ trống',
		    'password.min' => 'Mật khẩu tối thiểu là 6 ký tự',
            're_password.required' => 'Mật khẩu nhập lại không được bỏ trống',
		    're_password.same' => 'Mật khẩu nhắc lại không trùng',
		    'first_name.required' => 'Họ không được bỏ trống',
		    'last_name.required' => 'Tên và tên đệm không được bỏ trống'
	    ];
    }
}
