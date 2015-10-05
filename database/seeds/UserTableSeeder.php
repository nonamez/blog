<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
	public function run()
	{
		User::create(array(
			'email'    => 'admin@nonamez.name',
			'password' => Hash::make('password')
		));
	}
}
