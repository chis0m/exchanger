<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;
use Exception;

trait ApiResponse
{
    public function success(string $message = "Successful", array $data = [], int $statusCode = Response::HTTP_OK)
    {
        $response = [
            "success" => true,
            "message" => $message,
            "data" => $data
        ];
        return response()->json($response, $statusCode);
    }

    public function error($message = 'error', $statusCode = Response::HTTP_BAD_REQUEST, array $data = null)
    {
        $response = [
            "success" => false,
            "message" => $message,
            "data" => $data
        ];
        return response()->json($response, $statusCode);
    }

    public function fatalError(Exception $e, int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $line = $e->getTrace();

        $error = [
            "message" => $e->getMessage(),
            "trace" => $line[0],
            "mini_trace" => $line[1]
        ];

        if (strtoupper(config("APP_ENV")) === "PRODUCTION") {
            $error = null;
        }

        $response = [
            "success" => false,
            "message" => "Oops! Something went wrong on the server",
            "error" => $error
        ];
        return response()->json($response, $statusCode);
    }

    public function respond(Exception $e)
    {
        $trace = [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'code' => $e->getCode(),
            'time' => \Carbon\Carbon::now()->toDayDateTimeString(),
        ];
        $code = ($e->getCode()) ? $e->getCode() : 500;
        if ($code < 500) {
            return $this->error(null, $e->getMessage(), $code);
        }
        return $this->fatalError($e);
    }
}
