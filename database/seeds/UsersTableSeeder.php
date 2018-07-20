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
            'name' => 'John Dave Decano',
            'email' => 'johndave.decano@qualitytrade.com',
            'is_verified' => true,
            'password' => 'password'
        ]);

    }
}
