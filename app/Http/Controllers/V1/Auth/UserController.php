<?php namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;

class UserController extends Controller
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
        $this->middleware('auth:api');

        $this->authService = $authService;
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $data = $this->authService->getCurrentUser();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
