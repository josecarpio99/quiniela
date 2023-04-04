<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{

    protected $limit = 10;

    public function success($message, $data = [], $status = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data'    => $data
        ], $status);
    }

    public function error($message, $data = [], $status = 400): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data'    => $data
        ], $status);
    }

    public function unauthorized($message = 'Unauthorized', $status = 401)
    {
        return response()->json([
            'message' => $message
        ], $status);
    }
     /**
     * Respond with empty content.
     *
     * @return \Illuminate\Http\Response
     */
    public function noContent(): Response
    {
        return response()->noContent();
    }

    public function getDefaultPageLimit() : int
    {
        return $this->limit;
    }
}
