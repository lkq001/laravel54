<?php
/**
 *
 *
 * Created by PhpStorm.
 * User: likeqin
 * Date: 2017/12/16
 * Time: 23:22
 * author 李克勤
 */

namespace App\Service;

use App\Tools\Common;
use Illuminate\Support\Facades\Cache;
use Mockery\Exception;
use Illuminate\Support\Facades\Request;

class TokenService
{

    public static function generateToken()
    {
        // 获取32位随机字符串
        $randChars = Common::getRandChar(32);
        // 用三组字符串MD5加密
        $timestamp = $_SERVER['REQUEST_TIME'];
        // salt 盐
        $salt = config('secure.token_salt');

        return md5($randChars . $timestamp . $salt);
    }

    // 指定key,取内存值
    public static function getCurrentTokenVal($key)
    {
        $token = Request::instance()->header('token');

        $vars = Cache::get($token);

        if (!$vars) {
            return [
                'code' => '404',
                'msg' => '获取token参数错误',
                'errorCode' => '60003'
            ];
        } else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }

            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception('尝试获取变量并不存在');
            }
        }
    }

    // 获取token
    public static function getCurrnentUid()
    {
        // $token
        $uid = self::getCurrentTokenVal('uid');

        return $uid;
    }

    /**
     * 用户和cms管理员都可以访问全新啊
     *
     * @return array|bool
     * author 李克勤
     */
    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVal('scope');
        if ($scope) {
            if ($scope >= config('scope.user')) {
                return true;
            } else {
                return [
                    'code' => '403',
                    'msg' => '权限不够',
                    'errorCode' => '10001'
                ];
            }
        } else {
            return [
                'code' => '401',
                'msg' => 'Token已过期或无效Token',
                'errorCode' => '10001'
            ];
        }
    }

    /**
     * 只有用户可以访问的全新啊
     *
     * @return array|bool
     * author 李克勤
     */
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVal('scope');
        if ($scope) {
            if ($scope == config('scope.user')) {
                return true;
            } else {
                return [
                    'code' => '403',
                    'msg' => '权限不够',
                    'errorCode' => '10001'
                ];
            }
        } else {
            return [
                'code' => '401',
                'msg' => 'Token已过期或无效Token',
                'errorCode' => '10001'
            ];
        }
    }

    /**
     * 检测 UID 是否正确
     *
     * @param $checkedUID
     * @return array|bool
     * author 李克勤
     */
    public static function isValidPoerate($checkedUID)
    {
        if (!$checkedUID) {
            return [
                'code' => '403',
                'msg' => '检测UID必须传入一个被检测的UID',
                'errorCode' => '10001'
            ];
        }
        $currentOperateUID = self::getCurrnentUid();

        if ($currentOperateUID == $checkedUID) {
            return true;
        }
        return false;
    }
}