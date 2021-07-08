<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/3/2018
 * Time: 10:39 AM
 */

namespace Auth\Http\Controllers\Frontend;

use Auth\Supports\SocialAccountService;
use Base\Mail\CreateUser;
use Base\Mail\ReserPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Socialite;
use Users\Models\Users;
use Auth\Http\Requests\AuthRegisterRequest;
use Auth\Http\Requests\AuthLoginRequest;
use Barryvdh\Debugbar\Controllers\BaseController;
use Auth\Supports\Traits\AuthFrontend;
use Users\Repositories\UsersMetaRepository;

class AuthController extends BaseController
{
    use AuthFrontend;

    public function redirect($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function callback($social)
    {
        $user = SocialAccountService::createOrGetUser(Socialite::driver($social)->user(), $social);
        auth()->login($user);

        return $this->sendLoginResponse(request());
    }

    public function getLogin()
    {
        return view('nqadmin-auth::frontend.login');
    }

    public function getRegister()
    {
        return view('nqadmin-auth::frontend.register');
    }

    public function postRegister(
        AuthRegisterRequest $request,
        UsersMetaRepository $usersMetaRepository
    )
    {
        try {
            if (isset($request->newsletter)) {
                $request->merge(['newsletter' => 'active']);
            }
            $user = Users::create($request->except('_token'));
            Mail::to($user)->queue(new CreateUser($user));
            $usersMetaRepository->create([
                'users_id' => $user->id,
                'meta_key' => 'autoplay',
                'meta_value' => true,
                'status' => 'active',
                'hard_role' => 1
            ]);
            auth()->login($user);
            return redirect()->to('/');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function postLogin(AuthLoginRequest $request)
    {
        return $this->login(request());
    }

    public function authenticated()
    {
        return redirect()->route('front.home.index.get');
    }

    public function sendResetPassword($token)
    {
        $datas = DB::table('password_resets')->get();
        foreach ($datas as $data) {
            if (Hash::check($token, $data->token)) {
                $user = Users::whereEmail($data->email)->first();
                $new_pass = str_random();
                $user->password = $new_pass;
                $user->save();
                Mail::to($user)->queue(new ReserPassword($user, $new_pass));
            }
        }
        return redirect(route('front.home.index.get'))->with('success', 'Email Reset password đã được gửi đi!');
    }

    public function getLogout()
    {
        $this->guard()->logout();

        session()->flush();

        session()->regenerate();

        return redirect()->route('front.home.index.get');
    }

}