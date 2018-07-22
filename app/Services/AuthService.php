<?php namespace App\Services;

use Exception;
use App\Repositories\UserRepository;
use App\Services\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;
use App\Models\CustomNotifiable;

/**
 * AuthService - Handles all logics for authentication domain.
 */
class AuthService implements AuthServiceInterface
{
    /**
     * @var App\Repositories\UserRepository
     */
    private $userRepo;

    /**
     * @param UserRepository $userRepo
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Gets the current user
     *
     * @return object
     */
    public function getCurrentUser()
    {
        $user = Auth::guard()->user();

        if (!$user) {
            throw new AuthenticationException('Someone needs to be logged in.');
        }

        if (!$user->is_activated) {
            throw new AuthenticationException('Account is not yet verified.');
        }

        return $user;
    }

    /**
     * Logs in a user
     *
     * @param string $email
     * @param string $password
     * @return array
     */
    public function login($email, $password)
    {
        $token = Auth::guard()->attempt(['email' => $email, 'password' => $password]);

        if (!$token) {
            throw new AuthenticationException('Invalid email or password.');
        }

        $user = Auth::guard()->user();

        if (!$user->is_activated) {
            throw new AuthenticationException('Account is not yet verified.');
        }

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }

    /**
     * Logs out a user
     *
     * @return void
     */
    public function logout()
    {
        Auth::logout();

        return;
    }

    /**
     * Refreshes current user token
     *
     * @return void
     */
    public function refreshToken()
    {
        return [
            'access_token' => Auth::refresh(),
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }

    /**
     * Sends email reset instruction to the user
     *
     * @param string $email
     * @return mixed
     */
    public function forgot($email)
    {
        $user = $this->userRepo->findBy('email', $email);

        if (!$user) {
            throw new AuthenticationException('Invalid user credentials');
        }

        $broker = $this->broker();

        $response = $broker->sendResetLink(['email' => $email]);

        if ($response !== Password::RESET_LINK_SENT) {
            throw new Exception('Unable to send reset email.');
        }

        return $user;
    }

    /**
     * Resets user password.
     *
     * @param array $credentials
     *
     * @return void
     */
    public function reset($credentials = [])
    {
        $response = $this->broker()->reset(
            $credentials,
            function ($user, $password) {
                $user->password = $password;
                $user->is_activated = true;
                $user->save();
            }
        );

        if ($response !== Password::PASSWORD_RESET) {
            throw new AuthenticationException('Unable to reset password.');
        }

        return $response;
    }

    /**
     * Resends user activation email.
     *
     * @param string $email
     *
     * @return void
     */
    public function resend($email)
    {
        $user = $this->userRepo->findBy('email', $email);

        if (!$user) {
            throw new AuthenticationException('Invalid user credentials');
        }

        $user->sendActivationEmail();

        return $user;
    }

    /**
     * Registers a new user account.
     *
     * @param array $credentials
     * @return array
     */
    public function register($credentials = [])
    {
        $user = $this->userRepo->create(array_merge(
            $credentials,
            [
                'is_activated' => false,
                'activation_token' => Password::getRepository()->createNewToken(),
                'activation_token_expires_at' => Carbon::now()->addHour(24)
            ]
        ));

        $user->sendActivationEmail();

        return $credentials;
    }

    /**
     * Activates a user account.
     *
     * @param string $token
     * @return object
     */
    public function activate($token)
    {
        $user = $this->userRepo->findBy('activation_token', $token);

        if (!$user) {
            throw new AuthenticationException('Invalid activation token.');
        }

        if ($user->is_activated) {
            throw new AuthenticationException('User is already activated.');
        }

        if (!$user->activation_token_expires_at) {
            throw new AuthenticationException('Invalid token expiration date.');
        }

        if (!$user->activation_token_expires_at->isFuture()) {
            throw new AuthenticationException('Token is already expired.');
        }

        $user->is_activated = true;
        $user->activation_token = null;
        $user->activation_token_expires_at = null;
        $user->save();

        return $user;
    }

    /**
     * Sends update email confirmation to users current email.
     *
     * @param string $email
     * @return void
     */
    public function resetEmail($email)
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            throw new AuthenticationException('Invalid user credentials');
        }

        $token = Password::getRepository()->createNewToken();

        $this->userRepo->update([
            'email_reset' => $email,
            'email_reset_token' => $token,
            'email_reset_expires_at' => Carbon::now()->addHour(24)
        ], $user->id);

        $notifiable = new CustomNotifiable($email);
        $notifiable->sendUpdateEmailNotification($token);

        return $user;
    }

    /**
     * Updates user email once token is validated.
     *
     * @param string $token
     *
     * @return object
     */
    public function activateEmail($token)
    {
        $user = $this->userRepo->findBy('email_reset_token', $token);

        if ($user &&
            $user->email_reset_expires_at &&
            $user->email_reset &&
            $user->email_reset_token &&
            $user->email_reset_expires_at->isFuture()
        ) {
            $user->email = $user->email_reset;
            $user->email_reset = null;
            $user->email_reset_token = null;
            $user->email_reset_expires_at = null;
            $user->save();
            return $user;
        }

        throw new AuthenticationException('Invalid email activation token.');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    private function broker()
    {
        return Password::broker();
    }
}
