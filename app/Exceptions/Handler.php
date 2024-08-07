<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
        \Tymon\JWTAuth\Exceptions\JWTException::class,
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param $request
     * @param  Throwable  $ex
     * @return JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $ex): JsonResponse
    {
        if ($ex instanceof \DomainException) {
            return response()->json([
                'message' => $ex->getMessage(),
                // 'errors' => $ex->errors(),
            ], Response::HTTP_FORBIDDEN);
        }

        if ($ex instanceof ValidationException) {
            return response()->json([
                'message' => 'Validation exception',
                'errors' => $ex->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($ex instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'Model not found',
                'error' => class_basename($ex->getModel()).' not found',
            ], Response::HTTP_NOT_FOUND);
        }

        if ($ex instanceof BadRequestException) {
            return response()->json([
                'message' => $ex->getMessage(),
                'error' => 'Bad request exception',
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($ex instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'Not found http exception',
                'error' => $ex->getMessage(),
            ],
                Response::HTTP_NOT_FOUND);
        }

        if ($ex instanceof AuthenticationException) {
            return response()->json([
                'message' => 'Authentication exception',
                'error' => str_replace(['.'], [''], $ex->getMessage()), // 'Unauthorized',
            ],
                Response::HTTP_UNAUTHORIZED);
        }

        // dd($ex);
        // dd($ex->getPrevious());

        return response()->json([
            // 'message' => 'Unauthenticated',
            'error' => $ex->getMessage(),
            'file' => $ex->getFile(),
            'line' => $ex->getLine(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);

        return parent::render($request, $ex); // TODO: Change the autogenerated stub
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        dd(__METHOD__);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if ($request->is('admin') || $request->is('admin/*')) {
            return redirect()->guest('/admin');
        }

        return redirect()->guest(route('login'));
    }
}
