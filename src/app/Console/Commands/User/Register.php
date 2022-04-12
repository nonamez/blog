<?php

namespace App\Console\Commands\User;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

use App\Models;

class Register extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register new user through command line';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->ask('Email');
        $name  = $this->ask('Name');

        $validator = Validator::make(compact('name', 'email'), [
            'email' => ['required', 'email', 'unique:users,email'],
            'name'  => ['required', 'string', 'min:3'],
        ]);

        if ($validator->fails()) {
            $this->info('User not created. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
        } else {
            $password = Str::random(8);

            $user = new Models\Users\User();

            $user->password = bcrypt($password);

            $user->email = $email;
            $user->name  = $name;

            $user->save();

            $abilities = array_keys(Gate::abilities());

            foreach ($abilities as $ability) {
                $user->abilities()->create([
                    'name' => $ability
                ]);
            }

            $this->info(sprintf('User "%s" ("%s") with password "%s" successfully created.', $name, $email, $password));
        }
    }
}
