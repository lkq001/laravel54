<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\ProductRequest;
use App\Service\OrderService;
use App\Service\TokenService;
use Validator;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    // 1: 用户在选择商品后,想API提交包含他所选择商品的相关信息
    // 2: API 在接受到信息后,需要检查订单相关商品的库存量
    // 3: 有库存,吧订单数据存入数据库中.下单成功了,返回客户端消息,告诉客户端可以支付了
    // 4: 调用我们的支付接口,进行支付
    // 5: 还需要再次进行库存量检测
    // 6: 服务器这边就可以调用微信的支付接口进行支付
    // 7: 微信会返回给我们一个支付的结果
    // 8: 成功,进行库存量的扣除, 失败: 返回之歌支付失败的结果

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
        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }
}