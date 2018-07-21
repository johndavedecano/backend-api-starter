<?php namespace App\Models;

use Hash;

use App\Models\Traits\AuthNotifications;
use Illuminate\Notifications\Notifiable;

class CustomNotifiable
{
    use Notifiable;
    use AuthNotifications;

    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
    }
}
