<?php

namespace D3\KlicktippPhpClient\Exceptions;

use Exception;

class BaseException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $message = 'Klicktipp error: '.$message;
        parent::__construct($message, $code, $previous);
    }
}
