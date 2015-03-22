<?php


class DatabaseSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();

		$this->call('FirstPostAndTagSeeder');
		
		Eloquent::reguard();
	}
}
