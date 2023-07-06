<?php

namespace App\Exceptions;

use Exception;

class InvalidCredentialsException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = 'Unauthorised', $code = 401)
    {
        $this->message = $message;
        $this->code = $code;
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->message,
        ], $this->code);
    }
}
