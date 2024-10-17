<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($res, $msg) {
        $res = [
            'success' => true,
            'data'    => $res,
            'message' => $msg,
        ];

        return response()->json($res, 200);
    }

    public function sendError($err, $err_msg = [], $code = 404) {
        $res = [
            'success' => false,
            'message' => $err
        ];

        if(!empty($err_msg)){
            $res['data'] = $err_msg;
        }

        return response()->json($res, $code);
    }
}
