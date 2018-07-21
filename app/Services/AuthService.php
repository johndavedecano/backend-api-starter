<?php namespace App\Services;

use Exception;
use App\Repositories\UserRepository;
use App\Services\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Password;

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

        if (!$user->is_verified) {
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

        if (!$user->is_verified) {
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
                $user->save();
            }
        );

        if ($response !== Password::PASSWORD_RESET) {
            throw new AuthenticationException('Unable to reset password.');
        }

        return $response;
    }

    /**
     * Registers a new user account.
     *
     * @param array $credentials
     * @return void
     */
    public function register($credentials = [])
    {

    }

    /**
     * Activates a user account.
     *
     * @param string $token
     * @return void
     */
    public function activate($token)
    {

    }

    /**
     * Sends update email confirmation to users current email.
     *
     * @param string $email
     * @return void
     */
    public function resetEmail($email)
    {

    }

    /**
     * Updates user email once token is validated.
     *
     * @param string $token
     * @param string $email
     * @return void
     */
    public function activateEmail($token, $email)
    {

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