<?php

namespace App\Traits;

trait ResponseTrait
{
    protected function dataResponse($code, $data = null)
    {
        return response()->json($data, $code);
    }

    protected function successResponse($code, $message, $data = null)
    {
        $body = [
            'message' => $message
        ];
        if (!empty($data)) {
            $body['data'] = $data;
        }
        return response()->json($body, $code);
    }

    protected function errorResponse($code, $message, $error = null)
    {
        $body = [
            'message' => $message
        ];
        if (!empty($error)) {
            $body['errors'] = $error;
        }
        return response()->json($body, $code);
    }
}
