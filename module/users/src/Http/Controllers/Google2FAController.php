<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 1/2/2018
 * Time: 2:05 PM
 */

namespace Users\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Crypt;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \ParagonIE\ConstantTime\Base32;
use Users\Models\Users;
use Users\Http\Requests\ValidateSecretRequest;

class Google2FAController extends BaseController
{
	use ValidatesRequests;
	
	public function __construct()
	{
		$this->middleware('web');
	}
	
	/**
	 * Create secret key and genenerate Barcode image
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function enableTwoFactor(Request $request)
	{
		//generate new secret
		$secret = $this->generateSecret();
		
		//get user
		$user = $request->user();
		
		//encrypt and then save secret
		$user->google2fa_secret = Crypt::encrypt($secret);
		$user->save();
		
		//generate image for QR barcode
		$google2fa = new Google2FA();
		$imageDataUri = $google2fa->getQRCodeInline(
			$request->getHttpHost(),
			$user->email,
			$secret,
			200
		);
		
		return view('nqadmin-users::backend.2fa.enable', [
			'image' => $imageDataUri,
			'secret' => $secret
		]);
	}
	
	/**
	 * Return view disable for last submit
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function disableTwoFactor(Request $request)
	{
		// Re render image and secret key if user doest have on Google Authenticator
		$id = $request->get('id');
		$model = new Users;
		$user = $model->find($id);
		$google2fa_secret = $user->google2fa_secret;
		$secret = Crypt::decrypt($google2fa_secret);
		
		$google2fa = new Google2FA();
		$imageDataUri = $google2fa->getQRCodeInline(
			$request->getHttpHost(),
			$user->email,
			$secret,
			200
		);
		
		return view('nqadmin-users::backend.2fa.disable', [
			'image' => $imageDataUri,
			'secret' => $secret
		]);
	}
	
	/**
	 * Clear google2fa_secret field
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function disableTwoFactorPost(ValidateSecretRequest $request)
	{
		$id = $request->get('user_id');
		$model = new Users;
		$user = $model->find($id);
		//make secret column blank
		$user->google2fa_secret = null;
		$user->save();
		return redirect()->route('nqadmin::users.edit.get');
	}
	
	/**
	 * Generate secret with Base32
	 *
	 * @return string
	 */
	private function generateSecret()
	{
		$randomBytes = random_bytes(10);
		
		return Base32::encodeUpper($randomBytes);
    }
}