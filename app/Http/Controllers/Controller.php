<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public static function success($data, $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $statusCode);
    }

    public static function error($message, $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $statusCode = $statusCode >= 400 && $statusCode < 600 ? $statusCode : 400;
        return response()->json(['error' => $message], $statusCode);
    }
}
