<?php namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Http\Requests\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    /**
     * @var App\Services\AuthService
     */
    private $authService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(ResetPasswordRequest $request)
    {
        $data = $this->authService->reset(
            $request->only(['token', 'email', 'password', 'password_confirmation'])
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Password was successfully reset.'
        ]);
    }
}