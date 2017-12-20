<?php

namespace App\Http\Controllers\Api\V1;

use App\Service\PayService;
use App\Service\WxNotifyService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class PayController extends Controller
{

    /**
     *
     *
     * @param Request $request
     * @return array|null
     * author 李克勤
     */
    public function getPreOrder(Request $request)
    {
//        $validator = Validator::make($request->all(), [
//            'id' => 'required|int'
//        ]);
//
//        if ($validator) {
//            return [
//                'code' => 404,
//                'msg' => '参数错误',
//                'errorCode' => 60000
//            ];
//        }

        $payment = new PayService($request->id);

        return $payment->pay();
    }

    public function receiveNotify()
    {
        $notify = new WxNotifyService();
        $notify->Handle();
    }

//    public function receiveNotify()
//    {
//        $xmlData = file_get_contents('php://input');
//        $result = curl_post_raw('http:/lkq.laravel54.com/api/pay/re_notify?XDEBUG_SESSION_START=13322',
//            $xmlData);
//
//    }
}
