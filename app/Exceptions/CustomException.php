<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }
}
