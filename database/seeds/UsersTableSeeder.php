<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'id' => 1,
            'first_name' => 'John Dave',
            'last_name' => 'Decano',
            'email' => 'johndave.decano@qualitytrade.com',
            'is_activated' => true,
            'password' => 'password'
        ]);

    }
}
