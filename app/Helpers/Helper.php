<?php

if(!function_exists('getTakenPreparedCollection')) {
    /**
     * get final paginated data.
     *
     * @param collection $collection
     * @param array $requestData
     * @return array
     */
    function getTakenPreparedCollection($collection, $requestData)
    {
        $take  = !empty($requestData['take']) ? ($requestData['take'] == -1 ? 50000000 : $requestData['take']) : 10;
        $skip  = !empty($requestData['skip']) ? $requestData['skip'] : 0;
        $data['total']     = $collection->count();
        $data['list']      = $collection->skip($skip)->take($take)->get();
        $data['count']     = $data['list']->count();
        $data['last_page'] = ceil($data['total'] / $take);
        return $data;
    }
}

if (!function_exists('Throwable')) {
    /**
     * return response of all project api's
     * @param  Throwable $exception
     * @return \Illuminate\Http\JsonResponse
    */
    function Throwable($exception) {
        if(is_string($exception->getCode()) || $exception->getCode() == 0)
            return sendMessage(false, __('Internal error, please try again later'), $exception->__toString(), 500);
    
        return sendMessage(false, $exception->getMessage(), $exception->__toString(), $exception->getCode());
    }
}