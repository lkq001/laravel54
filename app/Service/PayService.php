<?php
/**
 *
 *
 * Created by PhpStorm.
 * User: likeqin
 * Date: 2017/12/20
 * Time: 10:08
 * author 李克勤
 */

namespace App\Service;

use App\Model\Order;

use WxPayApi;

class PayService
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if (!$orderID) {
            return [
                'code' => '404',
                'msg' => '订单号不允许为NULL',
                'errorCode' => '80000'
            ];
        }

        $this->orderID = $orderID;
    }

    // 支付
    public function pay()
    {
        // 检测订单号是否存在
        // 检测订单号是否正确(订单号和用户不匹配)
        // 检测订单号状态(订单有可能已经被支付)
        $this->checkOrderValid();

        // 进行库存量检测
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);

        if (!$status['pass']) {
            return $status;
        }

        return $this->makeWxPreOrder($status['orderPrice']);

    }

    // 发送预订单
    private function makeWxPreOrder($totalPrice)
    {
        // 获取openid
        $openid = TokenService::getCurrentTokenVal('openid');

        if (!$openid) {
            return [
                'code' => '404',
                'msg' => 'openid不存在',
                'errorCode' => '80000'
            ];
        }

        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody(config('common.system.title'));
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('secure.pay_back_url'));
        return $this->getPaySignature($wxOrderData);

    }

    private function getPaySignature($wxOrderData)
    {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);

        if ($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS') {
            \Log::info(collect($wxOrder)->toArray());
            \Log::info('获取预支付订单失败');
        }

        // prepay_id
        $this->recordPreOrder($wxOrder);
        $signature = $this->sign($wxOrder);

        return $signature;
    }

    private function sign($wxOrder)
    {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());

        $rand = md5(time() . mt_rand(0, 1000));
        $jsApiPayData->SetNonceStr($rand);

        $jsApiPayData->SetPackage('prepay_id=' . $wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');

        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;

        unset($rawValues['appId']);

        return $rawValues;
    }

    private function recordPreOrder($wxOrder)
    {
        Order::where('id', $this->orderID)->update([
            'prepay_id' => $wxOrder['prepay_id']
        ]);
    }

    /**
     * 检测订单是否允许支付
     *
     * @return array|bool
     * author 李克勤
     */
    private function checkOrderValid()
    {
        $order = Order::where('id', $this->orderID)->first();
        if (!$order) {
            return [
                'code' => '404',
                'msg' => '订单不存在',
                'errorCode' => '80000'
            ];
        }

        if (!TokenService::isValidPoerate($order->user_id)) {
            return [
                'code' => '404',
                'msg' => '订单与用户不匹配',
                'errorCode' => '10003'
            ];
        }

        if ($order->status != config('order.status.UNPAID')) {
            return [
                'code' => '404',
                'msg' => '订单状态不正确',
                'errorCode' => '10003'
            ];
        }
        $this->orderNO = $order->order_no;

        return true;
    }

}