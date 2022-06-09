<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     * @param Request $request
     * @param Throwable $e
     * @return Response
     * @throws Exceptions\ArrayWithMixedKeysException
     * @throws Exceptions\ConfigurationNotFoundException
     * @throws Exceptions\IncompatibleTypeException
     * @throws Exceptions\InvalidTypeException
     * @throws Exceptions\MissingConfigurationKeyException
     * @throws Exceptions\NotIntegerException
     */
    public function render($request, Throwable $e)
    {
        return ExceptionHelper::render($request, $e);
    }


}
