<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 2:33 PM
 */

namespace ClassLevel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditClassLevelRequest extends FormRequest
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
		$id = intval($this->get('current_id'));
		return [
			'name' => 'required',
			'slug' => 'required|unique:classlevel,slug,'.$id.',id',
			'editor' => 'required',
            'email' => 'email',
            'phone' => ['regex:/([\+84|84|0]+(3|5|7|8|9|1[2|6|8|9]))+([0-9]{8})\b/'],
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
			'slug.unique' => 'Slug này đã tồn tại',
			'editor.required' => 'Người chỉnh sửa Công ty không được bỏ trống',
            'phone.regex' => 'Số điện thoại không đúng',
            'email.email' => 'Định dạng Email không đúng',
		];
	}
}