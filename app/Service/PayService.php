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
    public function pay($orderID)
    {
        // 检测订单号是否存在
        // 检测订单号是否正确(订单号和用户不匹配)
        // 检测订单号状态(订单有可能已经被支付)
        $this->checkOrderValid();

        // 进行库存量检测
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($orderID);

        if ($status['pass']) {
            return $status;
        }

    }

    // 发送预订单
    private function makeWxPreOrder()
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