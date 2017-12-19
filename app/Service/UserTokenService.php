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

namespace App\Service;

use App\Exceptions\ApiException;
use App\Tools\Common;
use Mockery\Exception;
use App\Model\Users;
use Illuminate\Support\Facades\Cache;

class UserTokenService extends TokenService
{
    protected $code;
    protected $wxAppId;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppId = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'), $this->wxAppId, $this->wxAppSecret, $this->code);
    }

    public function get()
    {
        $result = Common::curl($this->wxLoginUrl);

        $wxResult = json_decode($result, true);

        if (empty($wxResult)) {
            throw new Exception('获取session_key及openID时异常,微信内部错误');
        } else {
            $loginFail = array_key_exists('errcode', $wxResult);

            if ($loginFail) {
                $this->processLoginError($wxResult);
            } else {
                return $this->grantToken($wxResult);
            }
        }
    }

    /**
     * 保存openid
     *
     * @param $wxResult
     * @return string
     * author 李克勤
     */
    private function grantToken($wxResult)
    {
        // 拿到openid
        // 数据库里面看一下,这个openid是否存在
        // 如果存在 则不处理, 如果不存在那么新增一条数据
        // 生成令牌,准备缓存数据,写入缓存
        // 把令牌返回到客户端
        $openid = $wxResult['openid'];

        $user = Users::getByOpenId($openid);

        if ($user) {
            $uid = $user->id;
        } else {
            $uid = $this->newUser($openid);
        }

        $cachedValue = $this->prepareCachedValue($wxResult, $uid);

        $token = $this->saveToCache($cachedValue);

        return $token;
    }

    /**
     * 令牌生成
     *
     * @param $cachedValue
     * @return string
     * @throws ApiException
     * author 李克勤
     */
    private function saveToCache($cachedValue)
    {
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');

        Cache::put($key, $value, $expire_in);

        if (!Cache::get($key)) {
            throw new ApiException('404', '服务器缓存异常', '10005');
        }

        return $key;
    }

    /**
     * 保存缓存数据
     *
     * @param $wxResult
     * @param $uid
     * @return mixed
     * author 李克勤
     */
    private function prepareCachedValue($wxResult, $uid)
    {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = 16;
        return $cachedValue;

    }

    /**
     * 创建新的user
     *
     * @param $openid
     * @return mixed
     * author 李克勤
     */
    private function newUser($openid)
    {
        $user = Users::create([
            'openid' => $openid
        ]);

        return $user->id;
    }

    // 错误
    private function processLoginError($wxResult)
    {
        throw new ApiException($wxResult['errmsg'], $wxResult['errcode']);
    }
}