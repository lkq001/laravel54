<?php
/**
 *
 *
 * Created by PhpStorm.
 * User: likeqin
 * Date: 2017/12/16
 * Time: 19:20
 * author 李克勤
 */

return [
    'app_id' => env('WX_APPID'),
    'app_secret' => env('WX_APPSECRET'),
    'login_url' => 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code'
 ];