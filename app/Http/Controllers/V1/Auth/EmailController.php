<?php namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Http\Requests\Auth\ActivateNewEmailRequest;
use App\Http\Requests\Auth\UpdateEmailRequest;

class EmailController extends Controller
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
        $this->middleware('auth:api', ['except' => ['activate']]);

        $this->authService = $authService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateEmailRequest $request)
    {
        $this->authService->resetEmail($request->get('email'));

        return response()->json([
            'status' => 'success',
            'message' => 'Email activation was sent to ' . $request->get('email')
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate(ActivateNewEmailRequest $request)
    {
        $this->authService->activateEmail($request->get('token'));

        return response()->json([
            'status' => 'success',
            'message' => 'Email was successfully updated.',
        ]);
    }
}
