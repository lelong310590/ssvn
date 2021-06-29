<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 11:17 AM
 */

namespace Coupon\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCouponRequest extends FormRequest
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
            'code' => 'required|unique:coupon',
            'reamain' => 'required',
            'deadline' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'code.required' => 'Mã giảm giá không được bỏ trống',
            'code.unique' => 'Mã giảm giá đã tồn tại trong hệ thống',
            'reamain.required' => 'Số lượng giảm giá không được bỏ trống',
            'deadline.required' => 'Ngày hết hạn không được bỏ trống'
        ];
    }
}