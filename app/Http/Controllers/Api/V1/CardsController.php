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

use App\Model\Cards;
use Illuminate\Http\Request;

class CardsController
{
    public function getCards()
    {
        $cards = Cards::limit(4)->get(['id', 'image', 'name', 'price']);

        if ($cards) {
            foreach ($cards as $value) {
                $value->image = config('filesystems.disks.qiniu.domains.default') . '/' . $value->image;
            }
        }

        return $cards;
    }

    // 获取指定宅配卡详情
    public function getOneCardById(Request $request)
    {
        $cards = Cards::where('id', $request->id)->first();

        if ($cards) {
            $cards->image = config('filesystems.disks.qiniu.domains.default') . '/' . $cards->image;

            // 获取描述信息
            $description = $cards->description;
            $cards->description = str_replace("/uploads", config('common.URL.image').'/uploads', $description);

        }

        return $cards;
    }
}