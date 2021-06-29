<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 10:22 AM
 */
return [
	'facebook' => [
		'client_id' => env('FACEBOOK_APP_ID'),
		'client_secret' => env('FACEBOOK_APP_SECRET'),
		'redirect' => env('FACEBOOK_APP_CALLBACK_URL'),
	],
	'github' => [
		'client_id' => env('GITHUB_APP_ID'),
		'client_secret' => env('GITHUB_APP_SECRET'),
		'redirect' => env('GITHUB_APP_CALLBACK_URL'),
	],
	'twitter' => [
		'client_id' => env('TWITTER_APP_ID'),
		'client_secret' => env('TWITTER_APP_SECRET'),
		'redirect' => env('TWITTER_APP_CALLBACK_URL'),
	],
	'google' => [
		'client_id' => env('GOOGLE_APP_ID'),
		'client_secret' => env('GOOGLE_APP_SECRET'),
		'redirect' => env('GOOGLE_APP_CALLBACK_URL'),
	]
];