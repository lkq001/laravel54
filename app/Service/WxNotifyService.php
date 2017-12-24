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


use App\Model\Cards;
use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\UserCards;
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
        foreach ($stockStatus['pStatusArray'] as $singlePStatus) {
            DB::table('cards')->where('id', $singlePStatus['id'])->decrement('stock', $singlePStatus['counts']);
        }

    }

    private function updateOrderStatus($orderID, $success)
    {
        $status = $success ? config('order.status.PAID') : config('order.status.PAID_BUT_OUT_OF');

        Order::where('id', $orderID)
            ->update(['status' => $status]);

        // 创建user_card数据

        // 查询产品信息
        $productLists = OrderProduct::where('order_id', $orderID)->get();

        if (collect($productLists)->count() <= 0) {
            \Log::info('订单创建失败');
            return false;
        }

        // 产品id
        $ids = [];
        $pNumber = [];
        foreach ($productLists as $v) {
            $ids[] = $v->product_id;
            $pNumber[] = $v->count;
        }

        \Log::info($ids);

        // 查询产品信息
        $cardInfo = Cards::whereIn('id', $ids)->get();
        if (collect($cardInfo)->count() <= 0) {
            \Log::info('宅配卡创建失败');
            return false;
        }

        $uid = TokenService::getCurrnentUid();
        if (!$uid) {
            \Log::info('用户不合法');
            return false;
        }

        foreach ($cardInfo as $key => $value) {

            $userCards = new UserCards();
            $userCards->user_id = 1;
            $userCards->card_id = $value->id;
            $userCards->card_code = $this->getCardCode();   // 生成
            $userCards->card_code_pw = mt_rand(10000000, 99999999);    // 随机生成八位数字
            $userCards->number = $value->number * $pNumber[$key];
            $userCards->number_count = $value->number * $pNumber[$key];
            $userCards->number_last = $value->number * $pNumber[$key];
            $userCards->card_source = 1;
            $userCards->address = '1';

            $userCards->save();

        }

    }

    public function getCardCode()
    {
        // 随机生成数字
        $code = '89' . mt_rand(1000000, 9999999);
        // 查询卡号是否存在
        $cardInfo = UserCards::where('card_code', $code)->count();
        if ($cardInfo > 0) {
            $this->getCardCode();
        } else {
            return $code;
        }

    }


}