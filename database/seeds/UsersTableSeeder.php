<?php

use Illuminate\Database\Seeder;

use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'username' => 'admin',
            'fullname' => 'Administrator',
            'password' => User::encrypt(env('DB_PASSWORD'))
        ]);

        factory(App\Models\User::class, 10)->create();
    }
}
