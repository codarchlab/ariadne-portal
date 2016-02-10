<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Mail;

class Handler extends ExceptionHandler {

  /**
   * A list of the exception types that should not be reported.
   *
   * @var array
   */
  protected $dontReport = [
    'Symfony\Component\HttpKernel\Exception\HttpException'
  ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e) {
        if (env('APP_ENV') != 'local') {
            if ($e instanceof Exception) {
                // page.email is the template of your email
                // it will have access to the $error that we are passing below
                Mail::send('page.email', ['error' => $e], function ($m) use ($e) {
                    $m->to('ariadne.project.eu@gmail.com', 'Ariadne Project')->subject('Error reporting');
                });
            }
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e) {

        if (env('APP_ENV') != 'local') {
            switch ($e) {
                case ($e instanceof NotFoundHttpException):
                    return response()->view('errors.404', [], 404);
                    break;

                case ($e instanceof BadRequest400Exception):
                    return response()->view('errors.badquery', [], 404);
                    break;

                case ($e instanceof HttpException):
                    return response()->view('errors.500', [], 500);
                    break;

                case ($e instanceof Exception):
                    return response()->view('errors.default', [], 500);
                    break;
            }
        }

        return parent::render($request, $e);
    }
}
