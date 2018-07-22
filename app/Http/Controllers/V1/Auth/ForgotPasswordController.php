<?php namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgot(ForgotPasswordRequest $request)
    {
        $this->authService->forgot($request->get('email'));

        return response()->json([
            'status' => 'success',
            'message' => 'Password reset instruction was successfully sent to ' . $request->get('email')
        ]);
    }
}
