<?php
/**
 * REST helper class
 * Small bicycle for REST responses
 */

namespace sys;


class REST
{
    public static function success($message = 'success', $data = null)
    {
        header('Content-Type: application/json');
        REST::response(array('code' => 200, 'message' => $message, 'data' => $data));
    }

    public static function error($code = 500, $message = 'error')
    {
        header('Content-Type: application/json');
        REST::response(array('code' => $code, 'message' => $message));
    }

    public static function response($data)
    {
        header('Content-Type: application/json');
        print(json_encode($data));
    }
}