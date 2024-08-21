<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception): JsonResponse
    {
        // Default response
        $response = [
            'error' => $exception->getMessage(),
            'status_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
        ];

        // Determine the type of exception and set the appropriate status code
        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            $response['error'] = $exception->getMessage();
            $response['status_code'] = Response::HTTP_NOT_FOUND;
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            $response['error'] = $exception->getMessage();
            $response['status_code'] = Response::HTTP_METHOD_NOT_ALLOWED;
        } elseif ($exception instanceof AuthenticationException) {
            $response['error'] = $exception->getMessage();
            $response['status_code'] = Response::HTTP_UNAUTHORIZED;
        } elseif ($exception instanceof ValidationException) {
            $response['error'] = $exception->getMessage();
            $response['status_code'] = Response::HTTP_UNPROCESSABLE_ENTITY;
            $response['details'] = $exception->errors(); // Include validation error details
        } elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            $response['error'] = $exception->getMessage();
            $response['status_code'] = $exception->getStatusCode();
        }

        // Log the exception for debugging purposes
        Log::error($exception);

        // Return the custom JSON response
        return response()->json($response, $response['status_code']);
    }
}
