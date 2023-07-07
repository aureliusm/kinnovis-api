<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse extends JsonResponse implements Responsable
{
    public function toResponse($request)
    {
        $status = match ($this->status()) {
            Response::HTTP_INTERNAL_SERVER_ERROR => 'Error',
            Response::HTTP_UNPROCESSABLE_ENTITY => 'Validation error',
            Response::HTTP_OK => 'Success',
            default => $this->status(),
        };

        $array = [
            'status' => $status,
            'locale' => app()->getLocale(),
        ];

        switch ($this->statusCode) {
            case Response::HTTP_INTERNAL_SERVER_ERROR:
            case Response::HTTP_UNPROCESSABLE_ENTITY:
                $array['errors'] = json_decode($this->data);
                break;
            default:
                $array['data'] = json_decode($this->data);
                break;
        }

        return response()->json($array, $this->statusCode);
    }
}
