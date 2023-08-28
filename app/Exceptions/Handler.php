<?php

namespace App\Exceptions;

use App\Traits\AjaxResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

class Handler extends ExceptionHandler
{
    use AjaxResponser;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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

    public function render($request, Throwable $e)
    {
        if($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        if($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }

        if($e instanceof AuthorizationException) {
            return $this->errorResponse($e->getMessage(), 403);
        }

        if($e instanceof NotFoundHttpException) {
            return $this->errorResponse("The specified URL cannot be found", 404);
        }

        if($e instanceof MethodNotAllowedException) {
            return $this->errorResponse("The specified method is invalid for this request", 405);
        }

        if($e instanceof ModelNotFoundException) {
            $modelName = class_basename($e->getModel());
            return $this->errorResponse("$modelName does not exist with the specific key", 404);
        }

        if($e instanceof HttpException) {
            return $this->errorResponse($e->getMessage(), $e->getStatusCode());
        }

        // Handled development/debugging level errors
        if(config('app.debug')) {
            return parent::render($request, $e);
        }

        // Handled production level errors
        return $this->errorResponse("Some Server Error Ocurred", 500);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        return $this->errorResponse($e->getMessage(), 422);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse("Unauthenticated", 401);
    }
}
