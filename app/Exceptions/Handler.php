<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param Exception $exception
     * @return boolean
     */
    private function isNotFoundException(Exception $exception)
    {
        return ($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        dd($exception);
        // Handles route not found and model not found.
        if ($request->wantsJson() && $this->isNotFoundException($exception)) {
            return response()->json([
                'status' => 'error',
                'message' => empty($exception->getMessage()) ? 'Page Not Found' : $exception->getMessage(),
            ], 404);
        }

        // Customize form validation errors.
        if ($request->wantsJson() && $exception instanceof ValidationException) {
            return response()->json([
                'status' => 'fail',
                'message' => $exception->errors(),
            ], 422);
        }

        // If error is unknown were gonna return a status 500.
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => empty($exception->getMessage()) ? 'Internal Server Error' : $exception->getMessage()
            ], 500);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->wantsJson()) {

            $message = empty($exception->getMessage()) ? 'You are not authorized' : $exception->getMessage();

            return response()->json([
                'status' => 'error',
                'message' => $message,
            ], 401);
        }

        return redirect()->guest('login');
    }
}
