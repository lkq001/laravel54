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
use Validator;

class UserAddressController
{
    // 保存修改地址
    public function createOrUpdateAddress(Request $request, Users $users, UserAddress $userAddress)
    {
        // 更具Token 获取用户的uid
        // 如果用户存在,获取用户从客户端传过来的信息
        // 根据用户地址信息是否存在,从而判断是添加地址或者 更新地址
        $uid = TokenService::getCurrnentUid();

        // 根据uid 获取用户数据,判断用户是否存在,如果不存在抛出异常
        $user = $users->where('id', $uid)->first();

        if (!$user) {
            return [
                'code' => 401,
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

    public function getUserAddress()
    {
        $uid = TokenService::getCurrnentUid();
        $userAddress = UserAddress::where('user_id', $uid)
            ->first();

        if (!$userAddress) {
            return [
                'code' => 401,
                'msg' => '用户地址不存在',
                'errorCode' => 60001
            ];
        }
        return $userAddress;
    }

    public function saveAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'countries' => 'required',
            'citys' => 'required',
            'areas' => 'required',
            'addres' => 'required',
            'username' => 'required',
            'tel' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([401, $validator->errors()->first()]);
        }

        // 获取userid
        $uid = TokenService::getCurrnentUid();

        if (!$uid) {
            return response()->json([401, '用户信息错误']);
        }

        $user = Users::where('id', $uid)->first();

        if (!$user) {
            return response()->json([401, '地址信息错误']);
        }

        $user->province = $request->countries;
        $user->city = $request->citys;
        $user->area = $request->areas;
        $user->address = $request->addres;
        $user->name = $request->username;
        $user->tel = $request->tel;

        if ($user->save()) {
            return response()->json([200, $user]);
        }
        return response()->json([401, '保存失败']);

    }

    /**
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     * author 李克勤
     */
    public function getPhoneCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json([401, '请输入手机号']);
        }

        header('content-type:text/html;charset=utf-8');

        $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL

        $rand = rand(100000, 999999);

        $smsConf = array(
            'key' => 'dd8e2617e77175a21ad9a99bcb9638a9', //您申请的APPKEY
            'mobile' => $request->phone, //接受短信的用户手机号码
            'tpl_id' => '57749', //您申请的短信模板ID，根据实际情况修改
            'tpl_value' => '#code#=' . $rand . '&#company#=绿行者' //您设置的模板变量，根据实际情况修改
        );

        $content = $this->juhecurl($sendUrl, $smsConf, 1); //请求发送短信

        if ($content) {
            $result = json_decode($content, true);
            $error_code = $result['error_code'];
            if ($error_code == 0) {
                return response()->json([200, ['code'=> $rand, 'tel' => $request->phone]]);
            } else {
                return response()->json([401, '获取验证码失败']);
            }
        } else {
            //返回内容异常，以下可根据业务逻辑自行修改
            return response()->json([401, '获取验证码失败,请联系客服']);
        }


    }

    /**
     * 请求接口返回内容
     * @param  string $url [请求的URL地址]
     * @param  string $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    function juhecurl($url, $params = false, $ispost = 0)
    {
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }
        $response = curl_exec($ch);
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }

    public function phoneUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json([401, '请输入手机号']);
        }

        // 获取userid
        $uid = TokenService::getCurrnentUid();

        if (!$uid) {
            return response()->json([401, '用户信息错误']);
        }

        $user = Users::where('id', $uid)->first();

        if (!$user) {
            return response()->json([401, '地址信息错误']);
        }

        $user->tel = $request->phone;

        if ($user->save()) {
            return response()->json([200, $user]);
        }
        return response()->json([401, '保存失败']);
    }

}