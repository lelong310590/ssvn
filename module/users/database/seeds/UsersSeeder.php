<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/25/2017
 * Time: 2:29 PM
 */

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
	public function run()
	{
		DB::table('users')->insert([
			[
				'email' => 'admin@3sgroup.vn',
				'password' => bcrypt('123456'),
				'first_name' => 'Administrator',
			],
			
			[
				'email' => 'mod@3sgroup.vn',
				'password' => bcrypt('123456'),
				'first_name' => 'Moderator',
			]
		]);
	}
}