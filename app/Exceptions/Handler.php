<?php

namespace App\Exceptions;

use App\Services\ModelNotFoundService;
use App\Services\RespondService;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return RedirectResponse|Response|\Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        $respondService = app(RespondService::class);
        if ($request->expectsJson()) {
            $respondService->setErrorMessages([]);
            $messages = [
                'user' => [
                    $exception->getMessage(),
                ],
            ];
            $respondService->error($messages, Response::HTTP_UNAUTHORIZED);

            return $respondService->toJson();
        }

        return redirect()->guest(route('login'));
    }

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
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        $respond = app(RespondService::class);

        if ($e instanceof ModelNotFoundException) {
            return ModelNotFoundService::handle($respond, $e);
        }

        if ($e instanceof Exception) {
            $message = $e->getMessage();
            $respond->errorException($message);

            return $respond->toJson();
        }

        if ($e instanceof NotFoundHttpException) {

            responder()->error("Route not found");

            return responder()->toJson(Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof MethodNotAllowedHttpException) {

            responder()->error(sprintf("Route exist, but method [%s] not allow", $request->method()));

            return responder()->toJson(Response::HTTP_NOT_FOUND);
        }

        $errorData = [
            'error' => $e->getMessage(),
            'file'  => $e->getFile(),
            'line'  => $e->getLine(),
            'input' => $request->input(),
        ];
        $respond->setErrorMessages($errorData);
        $respond->toJson();
        return parent::render($request, $e);
    }
}
