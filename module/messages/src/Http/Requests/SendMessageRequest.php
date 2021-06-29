<?php

namespace Messages\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
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
            'user_id' => 'required',
            'message' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => 'Không xác định được đối tượng gửi tin nhắn',
            'message.required' => 'Tin nhắn không được bỏ trống',
        ];
    }
}
