<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abilities = config('abilities');

        Models\Users\User::factory(10)->create()->each(function($user) use($abilities) {
            foreach ($abilities as $abilty) {
                $user->abilities()->create(['name' => $abilty]);
            }
        });
    }
}
