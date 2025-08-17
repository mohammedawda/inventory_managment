<?php

if (!function_exists('sendResponse')) {
    /**
     * Format a standard JSON API response.
     *
     * @param bool $status
     * @param string $message
     * @param mixed $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    function sendResponse(bool $status = true, string $message = '', $data = [], int $code = 200)
    {
        $response = [
            'status'  => $status,
            'message' => $message,
        ];

        if ($data instanceof Illuminate\Http\Resources\Json\JsonResource) {
            $response['data'] = $data;
        } elseif(is_array($data) && !empty($data)) {
            $response['total'] = $data['total'];
            $response['count'] = $data['count'];
            $response['data']  = $data['list'];
        }
        
        return response()->json($response, $code);
    }
}

if (!function_exists('sendMessage')) {
    /**
     * return response of all project api's
     * @param  boolean $status
     * @param  string $message
     * @param  int $code
     * @return json
    */
    function sendMessage($status, $message, $debug = "", $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            "status"  => $status,
            "message" => $message,
            "debug"   => $debug,
        ], (int)$code);
    }
}