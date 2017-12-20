<?php
/**
 *
 *
 * Created by PhpStorm.
 * User: likeqin
 * Date: 2017/12/20
 * Time: 10:51
 * author 李克勤
 */
return [
    'status' => [
        // 待支付
        'UNPAID' => 1,
        // 已支付
        'PAID' => 2,
        // 已发货
        'DELIVERED' => 3,
        // 已支付,但是库存不足
        'PAID_BUT_OUT_OF' => 4
    ]
];