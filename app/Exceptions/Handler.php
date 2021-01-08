<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return $this->error('Route Not Found', $exception->getStatusCode());
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->error($exception->getMessage(), $exception->getStatusCode());
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this
            ->error('Resource for ' . str_replace('App\\', '', $exception->getModel()) . ' not found', 500);
        }

        if ($exception instanceof UnauthorizedHttpException) {
            $preException = $exception->getPrevious();
            if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->error('UNAUTHENTICATED, TOKEN_EXPIRED', 401);
            } elseif ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->error('UNAUTHENTICATED, TOKEN_INVALID', 401);
                /** @phpstan-ignore-next-line */
            } elseif ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                return $this->error('UNAUTHENTICATED, TOKEN_BLACKLISTED', 401);
            }
            if ($exception->getMessage() === 'Token not provided') {
                return $this->error('UNAUTHENTICATED, TOKEN_NOT_PROVIDED', 401);
            }
        }

        return parent::render($request, $exception);
    }
}
