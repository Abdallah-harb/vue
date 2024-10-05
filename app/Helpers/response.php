<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('paginatedJsonResponse')) {
    /**
     * Paginated Json Response
     *
     * Used To Return Paginated Json Data
     * @param string|null $message
     * @param array|null $data
     * @param int|null $code
     * @param string|null $paginatedDataKey
     * @return JsonResponse
     */
    function paginatedJsonResponse(string|null $message = null, array|null $data = null, int|null $code = null, string|null $paginatedDataKey = null): JsonResponse
    {
        $code ??= Response::HTTP_OK;
        $paginatedDataKey ??= 'items';

        return response()->json([
            "code" => $code,
            "message" => $message ?? "Data with pajinated",
            "items" => $data[$paginatedDataKey],
            "pagination" => [
                "count" => (int)$data[$paginatedDataKey]->count(),
                "total" => (int)$data[$paginatedDataKey]->total(),
                "last_page" => (int)$data[$paginatedDataKey]->lastPage(),
                "per_page" => (int)$data[$paginatedDataKey]->perPage(),
                "current_page" => (int)$data[$paginatedDataKey]->currentPage(),
                // "get_options" => $data[$paginatedDataKey]->getOptions(),
                "next_page_url" => $data[$paginatedDataKey]->nextPageUrl(),
            ]
        ], $code);
    }
}
if (!function_exists('jsonResponse')) {
    /**
     * Json Response
     *
     * Used To Return Json Data
     * @param string|null $message
     * @param array|null $data
     * @param int|null $code
     * @return JsonResponse
     */
    function jsonResponse( array|null $data = null,string|null $message = null, int|null $code = null): JsonResponse
    {
        $code ??= Response::HTTP_OK;
        $message ??= "success";
        return response()->json(compact('code', 'message', 'data'), $code);
    }
}


if (!function_exists('errorResponse')) {
    /**
     * Error Json Response
     *
     * Used To Return Error Json Data
     * @param string $userMessage
     * @param array|null $errors
     * @param int|null $code
     * @return JsonResponse
     */
    function errorResponse(string $userMessage, array|null $errors = null, int|null $code = null): JsonResponse
    {
        return response()->json([
            "code" => $code ??= Response::HTTP_BAD_REQUEST,
            "message" => $userMessage,
            ...$errors ??= []
        ], $code);
    }
}
if (!function_exists('JsonResponseData')) {
    /**
     * Paginated Json Response
     *
     * Used To Return Paginated Json Data
     * @param string|null $message
     * @param array|null $data
     * @param int|null $code
     * @param string|null $paginatedDataKey
     * @return JsonResponse
     */

    function JsonResponseData(string|null $message = null,array|null $data = null, string $paginatedDataKey = null , int|null $code = null): JsonResponse {
        $code ??= Response::HTTP_OK;
        // Extracting paginated data
        $paginatedData = $data[$paginatedDataKey] ?? null;
        unset($data[$paginatedDataKey]);
        // Constructing response data
        $responseData = [
            'code' => $code,
            'message' => $message ?? "Success",
            'data' => $data,
        ];


        // If paginated data exists, include it in the response
        if ($paginatedData !== null) {

            $responseData['data'][$paginatedDataKey] = $paginatedData;
            $responseData['pagination'] = [
                'total' => $paginatedData->total(),
                'per_page' => $paginatedData->perPage(),
                'current_page' => $paginatedData->currentPage(),
                'last_page' => $paginatedData->lastPage(),
                'from' => $paginatedData->firstItem(),
                'to' => $paginatedData->lastItem(),
                'next_page_url' => $paginatedData->nextPageUrl(),
                'last_page_url' => $paginatedData->url($paginatedData->lastPage()),
                'previous_page_url' => $paginatedData->previousPageUrl(),
            ];
        }
        return response()->json($responseData, $code);
    }
}


