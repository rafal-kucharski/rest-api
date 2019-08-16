<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @param $result
     * @return Response
     */
    public function sendResponse($result)
    {
        $response = [
            'success' => true,
            'data' => $result,
        ];

        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @param $error
     * @param  array  $errorMessages
     * @param  int  $code
     * @return Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
