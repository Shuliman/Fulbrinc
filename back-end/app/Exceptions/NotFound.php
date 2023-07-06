<?php

namespace App\Exceptions;

use Exception;

class NotFound extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = 'Post not found', $code = 404) //hardcoded message as most popular, but this is a redefinable value
    {
        $this->message = $message;
        $this->code = $code;
    }

    public function render($request)
    {
        return response()->json([
            'success' => false,
            'message' => $this->message,
        ], $this->code);
    }
}
