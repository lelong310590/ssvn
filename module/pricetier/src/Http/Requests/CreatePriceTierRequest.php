<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/9/2018
 * Time: 3:32 PM
 */

namespace PriceTier\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePriceTierRequest extends FormRequest
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
			'price' => 'required|integer',
			'author' => 'required'
		];
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		return [
			'name.required' => 'Tên tầng giá không được bỏ trống',
			'price.required' => 'Giá không được bỏ trống',
			'price.integer' => 'Giá chỉ được là số',
			'author.required' => 'Tác giả tầng giá không được bỏ trống'
		];
	}
}