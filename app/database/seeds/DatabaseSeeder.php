<?php


class DatabaseSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();

		$this->call('FirstPostAndTagSeeder');
		$this->call('UserSeeder');
		
		Eloquent::reguard();
	}
}
