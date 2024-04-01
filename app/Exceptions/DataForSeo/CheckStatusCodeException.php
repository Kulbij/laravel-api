<?php

namespace App\Exceptions\DataForSeo;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CheckStatusCodeException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        $data = [
            'message' => ('order.remove.error'),
        ];

        return response()->json($data);
    }
}
