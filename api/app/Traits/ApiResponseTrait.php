<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ApiResponseTrait
{

    protected function successResponse($data = null, string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        $response = [
            'status' => 'success',
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }
    protected function errorResponse(string $message = 'Error', int $statusCode = 400, $errors = null): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    protected function resourceResponse(JsonResource $resource, string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $resource,
        ], $statusCode);
    }

    protected function collectionResponse(ResourceCollection $collection, string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $collection->resource->items(),
        ];

        if ($collection->resource instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $response['meta'] = [
                'current_page' => $collection->resource->currentPage(),
                'last_page' => $collection->resource->lastPage(),
                'per_page' => $collection->resource->perPage(),
                'total' => $collection->resource->total(),
                'from' => $collection->resource->firstItem(),
                'to' => $collection->resource->lastItem(),
            ];

            $response['links'] = [
                'first' => $collection->resource->url(1),
                'last' => $collection->resource->url($collection->resource->lastPage()),
                'prev' => $collection->resource->previousPageUrl(),
                'next' => $collection->resource->nextPageUrl(),
            ];
        }

        return response()->json($response, $statusCode);
    }

    protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    protected function validationErrorResponse($errors, string $message = 'Validation failed'): JsonResponse
    {
        return $this->errorResponse($message, 422, $errors);
    }
}