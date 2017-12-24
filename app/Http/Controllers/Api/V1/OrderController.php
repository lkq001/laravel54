<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Model\Order;
use App\Service\OrderService;
use App\Service\TokenService;
use Illuminate\Http\Request;
use Validator;

class OrderController extends BaseController
{
    // 1: 用户在选择商品后,想API提交包含他所选择商品的相关信息
    // 2: API 在接受到信息后,需要检查订单相关商品的库存量
    // 3: 有库存,吧订单数据存入数据库中.下单成功了,返回客户端消息,告诉客户端可以支付了
    // 4: 调用我们的支付接口,进行支付
    // 5: 还需要再次进行库存量检测
    // 6: 服务器这边就可以调用微信的支付接口进行支付
    // 7: 小程序根据服务器返回结果拉起微信支付
    // 8: 微信会返回给我们一个支付的结果
    // 9: 成功,进行库存量的扣除, 失败: 返回之歌支付失败的结果

    //
    protected $beforeActionList = [
        'needExclusiveScope' => ['only' => 'placeOrder']
    ];

    public function placeOrder(Request $request)
    {
        // 数据验证
        if (is_array($request->products)) {

            foreach (collect($request->products)->toArray() as $product) {
                if (!is_numeric($product['count']) || $product['count'] <= 0 || !is_numeric($product['product_id']) || $product['product_id'] <= 0) {
                    return [
                        'code' => '404',
                        'msg' => '商品信息不错',
                        'errorCode' => '80000'
                    ];
                }
            }

        }

        $products = $request->products;

        $uid = TokenService::getCurrnentUid('uid');
        \Log::info($uid);
        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }

    /**
     * 获取订单列表
     *
     * @return array
     * author 李克勤
     */
    public function getSummaryByUser()
    {
        $uid = TokenService::getCurrnentUid();

        $pagingOrders = Order::select('id', 'order_no', 'created_at', 'total_price', 'status', 'snap_img', 'snap_name', 'total_count')
            ->where('user_id', $uid)
            ->orderBy('created_at')
            ->paginate(config('order.pages.page'));

        if ($pagingOrders->isEmpty()) {
            return [
                'data' => [],
                'current_page' => $pagingOrders->currentPage()
            ];
        }
        $data = collect($pagingOrders)->toArray();
        return [
            'data' => $pagingOrders,
            'current_page' => $pagingOrders->currentPage()
        ];
    }

    public function getDetail(Request $request)
    {
        if (!$request->id) {
            return [
                'code' => '404',
                'msg' => 'id不存在',
                'errorCode' => '80000'
            ];
        }
        $orderDetail = Order::where('id', $request->id)->first();
        if (!$orderDetail) {
            return [
                'code' => '404',
                'msg' => '订单信息不存在',
                'errorCode' => '80000'
            ];
        }

        $orderDetail->snap_items = json_decode($orderDetail->snap_items);
        $orderDetail->snap_address = json_decode($orderDetail->snap_address);
        return $orderDetail;
    }

    public function orderList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pay' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json([401, '参数错误']);
        }

        $uid = TokenService::getCurrnentUid();
        if (!$uid) {
            return false;
        }

        // 查询订单信息
        if ($request->pay == 99) {
            $orderList = Order::where('user_id', $uid)->get();
        } else {
            $orderList = Order::where('user_id', $uid)
                ->where('status', $request->pay)->get();
        }
        if ($orderList) {
            foreach ($orderList as $value) {
                $value->snap_img = config('filesystems.disks.qiniu.domains.default') . '/' . $value->snap_img;
            }
        }
        return $orderList;
    }

}
