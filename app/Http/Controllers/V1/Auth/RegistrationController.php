<?php namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Requests\Auth\ActivateRequest;
use App\Http\Requests\Auth\ResendRequest;

class RegistrationController extends Controller
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
    public function register(RegistrationRequest $request)
    {
        $crendetials = ['first_name', 'last_name', 'email', 'password', 'password_confirmation'];

        $data = $this->authService->register(
            $request->only($crendetials)
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Regisration success. Activation email was sent to ' . $request->get('email')
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend(ResendRequest $request)
    {
        $data = $this->authService->resend($request->get('email'));

        return response()->json([
            'status' => 'success',
            'message' => 'Activation email was resent to ' . $request->get('email')
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate(ActivateRequest $request)
    {
        $data = $this->authService->activate($request->get('token'));

        return response()->json([
            'status' => 'success',
            'message' => 'Account was successfully activated.'
        ]);
    }
}