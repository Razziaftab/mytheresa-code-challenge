<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BaseService
{
    /**
     * @param string $data
     * @param string $message
     * @param string $status
     * @param int $code
     * @return JsonResponse
     */
    public static function response($data = null, string $message = 'OK', string $status = 'SUCCESS',
                                    int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status'    => $status,
            'message'   => $message,
            'data'      => $data,
        ], $code);
    }
}
