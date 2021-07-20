<?php
/**
 * TransferRequest.php
 * Created by: trainheartnet
 * Created at: 20/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
        $rule = [
            'employers' => 'required'
        ];

        if ($this->get('action') == 'transfer') {
            $rule['manager']  = 'required';
        }

        return $rule;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'employers.required' => 'Phải chọn người lao động để thực hiện tác vụ',
            'manager.required' => 'Phải chọn quản lý để tiếp nhận người lao động'
        ];
    }
}