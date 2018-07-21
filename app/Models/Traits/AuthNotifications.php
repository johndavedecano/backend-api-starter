<?php namespace App\Models\Traits;

use App\Notifications\ResetPasswordRequested;
use App\Notifications\AccountCreated;

trait AuthNotifications
{
    /**
     * Send activation email to the user
     */
    public function sendActivationEmail()
    {
        $this->notify(new AccountCreated($this->activation_token));
    }

    /**
     * Send a password reset email to the user.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordRequested($token));
    }
}
