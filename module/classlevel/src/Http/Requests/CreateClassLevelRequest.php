<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 11:59 AM
 */

namespace ClassLevel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClassLevelRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => 'required',
			'slug' => 'required|unique:classlevel,slug',
			'author' => 'required',
			'email' => 'email',
            'phone' => ['regex:/([\+84|84|0]+(3|5|7|8|9|1[2|6|8|9]))+([0-9]{8})\b/'],
            'first_name' => 'required',
            'last_name' => 'required',
            'citizen_identification' => 'required|min:9|max:12|unique:users,citizen_identification',
            'dob' => 'required',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required',
		];
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		return [
			'name.required' => 'Tên Công ty không được bỏ trống',
			'slug.required' => 'Slug Công ty không được bỏ trống',
			'slug.unique' => 'Slug Công ty đã được sử dụng',
			'author.required' => 'Tác giả Công ty không được bỏ trống',
            'phone.regex' => 'Số điện thoại không đúng',
            'email.email' => 'Định dạng Email không đúng',
            'first_name.required' => 'Họ không được bỏ trống',
            'last_name.required' => 'Tên và tên đệm không được bỏ trống',
            'phone.required' => 'Số điện thoại không được bỏ trống',
            'citizen_identification.required' => 'CMND/CCCD không được bỏ trống',
            'citizen_identification.min' => 'Số CMND/CCCD không hợp lệ',
            'citizen_identification.max' => 'Số CMND/CCCD không hợp lệ',
            'citizen_identification.unique' => 'Số CMND/CCCD này đã tồn tại',
            'dob.requỉed' => 'Ngày sinh không được bỏ trống',
            'province.required' => 'Tỉnh / Thành phố không được bỏ trống',
            'district.required' => 'Quận / Huyện không được bỏ trống',
            'ward.required' => 'Phường / Xã không được bỏ trống',
            'address.required' => 'Địa chỉ không được bỏ trống',
		];
	}
}