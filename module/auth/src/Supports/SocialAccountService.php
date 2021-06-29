<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 10:27 AM
 */

namespace Auth\Supports;

use Base\Mail\CreateUser;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Users\Models\SocialAccounts;
use Users\Models\Users;
use Users\Models\UsersMeta;

class SocialAccountService
{
    public static function createOrGetUser(ProviderUser $providerUser, $social)
    {
        $account = SocialAccounts::whereProvider($social)
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $email = $providerUser->getEmail() ?? $providerUser->getNickname() ?? $providerUser->getId() . '@facebook.com';
            $account = new SocialAccounts([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $social
            ]);
            $user = Users::whereEmail($email)->first();
            if (!$user) {
                $user = Users::create([
                    'email' => $email,
                    'first_name' => $providerUser->getName(),
                    'password' => $providerUser->getName(),
                    'thumbnail' => $providerUser->getAvatar(),
                ]);
                Mail::to($user)->queue(new CreateUser($user));
                UsersMeta::create([
                    'users_id' => $user->id,
                    'meta_key' => 'autoplay',
                    'meta_value' => true
                ]);
            }
            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}