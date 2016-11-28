<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\User::create([
			'email'    => 'admin@nonamez.name',
			'password' => bcrypt('password')
		]);
    }
}
