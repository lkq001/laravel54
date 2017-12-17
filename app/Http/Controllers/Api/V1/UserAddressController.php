<?php
/**
 *
 *
 * Created by PhpStorm.
 * User: likeqin
 * Date: 2017/12/16
 * Time: 12:46
 * author 李克勤
 */

namespace App\Http\Controllers\Api\V1;

use App\Model\UserAddress;
use App\Model\Users;
use App\Service\TokenService;
use Illuminate\Http\Request;

class UserAddressController
{
    // 保存修改地址
    public function createOrUpdateAddress(Request $request, Users $users, UserAddress $userAddress)
    {
//        // 数据验证
//        $validator = Validator::make($request->all(), [
//            'name' => 'required',
//            'mobile' => 'required|numeric',
//            'province' => 'required',
//            'city' => 'required',
//            'country' => 'required',
//            'detail' => 'required',
//        ]);
//        return $validator;
//        if ($validator) {
//            return [
//                'code' => 404,
//                'msg' => '参数错误',
//                'errorCode' => 60000
//            ];
//        }

        // 更具Token 获取用户的uid
        // 如果用户存在,获取用户从客户端传过来的信息
        // 根据用户地址信息是否存在,从而判断是添加地址或者 更新地址
        $uid = TokenService::getCurrnentUid();

        // 根据uid 获取用户数据,判断用户是否存在,如果不存在抛出异常
        $user = $users->where('id', $uid)->first();

        if (!$user) {
            return [
                'code' => 404,
                'msg' => '用户不存在',
                'errorCode' => 60001
            ];
        }

        $userAddressFirst = $userAddress->where('user_id', $uid)->first();

        if ($userAddressFirst) {
            // 修改
            $userAddress = $userAddressFirst;
        }

        $userAddress->name = $request->name;
        $userAddress->mobile = $request->mobile;
        $userAddress->province = $request->province;
        $userAddress->city = $request->city;
        $userAddress->country = $request->country;
        $userAddress->detail = $request->detail;
        $userAddress->user_id = $uid;

        if ($userAddress->save()) {
            return [
                'code' => 201,
                'msg' => 'ok',
                'errorCode' => 0
            ];
        }
        return [
            'code' => 404,
            'msg' => '操作失败',
            'errorCode' => 60002
        ];

    }
}