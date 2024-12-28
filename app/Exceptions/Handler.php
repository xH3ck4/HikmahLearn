<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Exceptions\ThrottleRequestsException;


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

    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*') && $this->isHttpException($exception) && $exception->getStatusCode() === 404) {
            return response()->json([
                'success' => false,
                'message' => 'API endpoint tidak ditemukan, silahkan baca dokumentasi API di web Hikmah Learn!'
            ], 404);
        }

        if ($exception instanceof ThrottleRequestsException) {
            return response()->json([
                'error' => 'Terlalu banyak percobaan. Coba lagi setelah beberapa saat. ('.$exception->getHeaders()['Retry-After'].'s)',
            ], 429);
        }


        return parent::render($request, $exception);
    }

}
