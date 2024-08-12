<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //

    /**
     * Return a success response.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $statusCode
     * @param  LengthAwarePaginator|null  $pagination
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data, $message = 'Request successful', $statusCode = 200, $pagination = null)
    {
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ];

        if ($pagination && $pagination instanceof LengthAwarePaginator) {
            $response['pagination'] = [
                'current_page' => $pagination->currentPage(),
                'per_page' => $pagination->perPage(),
                'total' => $pagination->total(),
                'last_page' => $pagination->lastPage(),
                'first_page_url' => $pagination->url(1),
                'last_page_url' => $pagination->url($pagination->lastPage()),
                'next_page_url' => $pagination->nextPageUrl(),
                'prev_page_url' => $pagination->previousPageUrl(),
            ];
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return an error response.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message = 'Request failed', $statusCode = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $statusCode);
    }

}
