<?php

class ErrorHandler
{
    public static function handleError(
        int $errorno,
        string $errormessage,
        string $errorfile,
        int $errorline
    ): void
    {
       throw new ErrorException($errormessage, 0, $errorno, $errorfile, $errorline);
    }

    public static function handleException(Throwable $exception): void 
    {
        http_response_code(500);
        echo json_encode([
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
    }
}