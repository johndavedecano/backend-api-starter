<?php namespace Tests\Feature;

use App\Models\User;

trait CreatesUserToken
{
    public function token($email = 'admin@admin.com', $password = 'password')
    {
        $user = new User([
            'first_name' => 'Dave',
            'last_name' => 'Decano',
            'email' => $email,
            'password' => $password,
            'is_activated' => true,
        ]);

        $user->save();

        $this->user = $user;

        $this->token = auth()->attempt(['email' => $email, 'password' => $password]);

        return $user;
    }
}