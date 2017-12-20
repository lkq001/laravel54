<?php
/**
 *
 *
 * Created by PhpStorm.
 * User: likeqin
 * Date: 2017/12/20
 * Time: 19:43
 * author 李克勤
 */

namespace App\Service;


use App\Model\Order;
use App\Model\OrderProduct;
use Illuminate\Support\Facades\DB;
use WxPayNotify;

class WxNotifyService extends WxPayNotify
{
    public function NotifyProcess($data, &$msg)
    {
        if ($data['result_code'] == 'SUCCESS') {
            $orderNo = $data['out_trade_no'];
            DB::beginTransaction();
            try {
                $order = Order::where('order_no', $orderNo)
                    ->lock(true)
                    ->first();
                if ($order->status == 1) {
                    $service = new OrderService();
                    $stockStatus = $service->checkOrderStock($order->id);
                    if ($stockStatus['pass']) {
                        $this->updateOrderStatus($order->id, true);
                        $this->reduceStock($stockStatus);
                    } else {
                        $this->updateOrderStatus($order->id, false);
                    }
                }
                DB::commit();
                return true;
            } catch (Exception $ex) {
                DB::rollback();
                \Log::error($ex);
                return false;
            }
        } else {
            return true;
        }
    }

    private function reduceStock($stockStatus)
    {
        \Log::info($stockStatus['pStatusArray']);
        foreach ($stockStatus['pStatusArray'] as $singlePStatus) {
            \Log::info($singlePStatus);
            DB::table('cards')->where('id', $singlePStatus['id'])->decrement('stock', $singlePStatus['counts']);
        }
    }

    private function updateOrderStatus($orderID, $success)
    {
        $status = $success ? config('order.status.PAID') : config('order.status.PAID_BUT_OUT_OF');

        OrderProduct::where('id', $orderID)
            ->update(['status' => $status]);
    }


}