<?php
/**
 *
 *
 * Created by PhpStorm.
 * User: likeqin
 * Date: 2017/12/16
 * Time: 19:11
 * author 李克勤
 */

namespace app\Service;

use App\Tools\Common;
use Mockery\Exception;


class UserTokenService
{
    protected $code;
    protected $wxAppId;
    protected $wxAppSecert;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppId = config('wx.app_id');
        $this->wxAppSecert = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'), $this->wxAppId, $this->wxAppSecert, $this->code);
    }

    public function get()
    {
        $result = Common::curl($this->wxLoginUrl);

        $wxResult = json_deconde($result, true);

        if (empty($wxResult)) {
            throw new Exception('获取session_key及openID时异常,微信内部错误');
        } else {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            } else {
                $this->grantToken($wxResult);
            }
        }
    }

    private function grantToken($wxResult)
    {

        // 拿到openid

        // 数据库里面看一下,这个openid是否存在

        // 如果存在 则不处理, 如果不存在那么新增一条数据

        // 生成令牌,准备缓存数据,写入缓存

        // 把令牌返回到客户端
    }

    // 错误
    private function processLoginError($wxResult)
    {
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }
}