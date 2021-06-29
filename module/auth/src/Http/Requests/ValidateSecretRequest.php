<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 1/2/2018
 * Time: 3:07 PM
 */

namespace Auth\Http\Requests;

use Cache;
use Crypt;
use PragmaRX\Google2FA\Google2FA;
use Users\Models\Users;
use Illuminate\Validation\Factory as ValidatonFactory;
use Illuminate\Foundation\Http\FormRequest;

class ValidateSecretRequest extends FormRequest
{
	/**
	 *
	 * @var \App\User
	 */
	private $user;
	
	/**
	 * Create a new FormRequest instance.
	 *
	 * @param \Illuminate\Validation\Factory $factory
	 * @return void
	 */
	public function __construct(ValidatonFactory $factory)
	{
		$this->user = Users::findOrFail(
			session('2fa:user:id')
		);
		$factory->extend(
			'valid_token',
			function ($attribute, $value, $parameters, $validator) {
				$secret = Crypt::decrypt($this->user->google2fa_secret);
				$google2fa = new Google2FA();
				return $google2fa->verifyKey($secret, $value);
			},
			'Mã xác minh không đúng'
		);
		
		$factory->extend(
			'used_token',
			function ($attribute, $value, $parameters, $validator) {
				$key = $this->user->id . ':' . $value;
				
				return !Cache::has($key);
			},
			'Mã này đã được sử dụng'
		);
	}
	
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		try {
			$this->user = Users::findOrFail(
				session('2fa:user:id')
			);
		} catch (\Exception $exc) {
			return false;
		}
		
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
			'totp' => 'bail|required|digits:6|valid_token|used_token',
		];
	}
}