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

    public function receiveNotify()
    {
        $notify = new WxNotifyService();
        $notify->Handle();
    }
}
