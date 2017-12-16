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

use App\Model\Banners;

class BannerController
{
    public function getBanner()
    {
        $banner = Banners::get(['image']);

        return $banner;
    }
}