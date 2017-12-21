<?php

namespace App\Http\Controllers\Api\V1;

use App\Service\PayService;
use App\Service\WxNotifyService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Tools\Common;

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
        $payment = new PayService($request->id);

        return $payment->pay();
    }

    public function redirectNotify()
    {
        $notify = new WxNotifyService();
        $notify->Handle();
    }

    public function receiveNotify()
    {
        $common = new Common();
        $xmlData = file_get_contents('php://input');
        $result =$common->curl_post_raw(config('secure.pay_back_url'),
            $xmlData);

    }
}
