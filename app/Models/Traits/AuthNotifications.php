<?php namespace App\Models\Traits;

use App\Notifications\ResetPasswordRequested;
use App\Notifications\AccountCreated;
use App\Notifications\EmailUpdateRequested;

trait AuthNotifications
{
    /**
     * Send activation email to the user
     *
     * @return void
     */
    public function sendActivationEmail()
    {
        $this->notify(new AccountCreated($this->activation_token));
    }

    /**
     * Send a password reset email to the user.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordRequested($token));
    }

    /**
     * Send an update email notification.
     *
     * @param string $token
     * @return void
     */
    public function sendUpdateEmailNotification($token)
    {
        $this->notify(new EmailUpdateRequested($token));
    }
}
