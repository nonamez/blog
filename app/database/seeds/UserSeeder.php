<?php
class UserSeeder extends Seeder {
	public function run()
	{
		User::create(array(
			'email'    => 'admin@nonamez.name',
			'password' => Hash::make('password')
		));
	}
}