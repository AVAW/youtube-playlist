<?php

namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait JsonResponseMethods
{

    protected function jsonSuccess($data = null, int $code = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse(
            [
                'success' => true,
                'error' => [],
                'data' => $data,
            ],
            $code,
            ['content-type' => 'application/json']
        );
    }

    protected function jsonFail($error = null, $code = Response::HTTP_BAD_REQUEST, $data = null): JsonResponse
    {
        return new JsonResponse(
            [
                'success' => false,
                'error' => $error,
                'data' => $data,
            ],
            $code,
            ['content-type' => 'application/json']
        );
    }

}
