<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
	public function run()
	{
		User::create(array(
			'email'    => env('ADMIN_EMAIL', 'admin@nonamez.name'),
			'password' => Hash::make(env('ADMIN_PASSWORD', 'password'))
		));
	}
}
