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

use App\Model\CardExcel;
use App\Model\Cards;
use App\Model\CardUse;
use App\Model\UserCards;
use App\Service\TokenService;
use Illuminate\Support\Facades\DB;
use Validator;
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
            $cards->description = str_replace("/uploads", config('common.URL.image') . '/uploads', $description);

        }

        return $cards;
    }

    // 开通宅配卡
    public function activation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'code_pw' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([401, $validator->errors()->first()]);
        }

        // 获取用户uid
        $uid = TokenService::getCurrnentUid();

        if (!$uid) {
            return response()->json([401, '您的信息不合法']);
        }
        // 根据uid 卡号  卡密 查询是否存在
        $cards = CardExcel::where('code', preg_replace('# #', '', $request->code))
            ->where('code_pw', $request->code_pw)
            ->where('status', 1)
            ->first();

        // 如果在导入表中
        if (collect($cards)->count() > 0) {
            // 执行添加

            DB::beginTransaction();
            try {
                $userCards = new UserCards();
                $userCards->user_id = $uid;
                $userCards->card_id = $cards->id;
                $userCards->card_code = preg_replace('# #', '', $request->code);
                $userCards->card_code_pw = $request->code_pw;
                $userCards->status = 2;
                $userCards->number = $cards->number;
                $userCards->number_count = $cards->number;
                $userCards->number_last = $cards->number;
                $userCards->card_source = 2;

                $userCards->save();

                $cards = CardExcel::where('code', preg_replace('# #', '', $request->code))
                    ->where('code_pw', $request->code_pw)
                    ->where('status', 1)
                    ->first();
                $cards->status = 2;
                $cards->user_id = $uid;
                $cards->save();

                DB::commit();
                return response()->json([200, '激活成功!']);
            } catch (Exception $ex) {
                DB::rollback();
                return response()->json([401, '激活失败!']);
                throw $ex;
            }
        } else {
            // 不在导入表中,查询用户拥有的配置卡表
            $cardsOnly = UserCards::where('card_code', preg_replace('# #', '', $request->code))
                ->where('card_code_pw', $request->code_pw)
                ->where('status', 1)
                ->first();

            if (collect($cardsOnly)->count() > 0) {
                DB::beginTransaction();
                try {
                    $userCardsTwo = new UserCards();
                    $userCardsTwo->user_id = $uid;
                    $userCardsTwo->card_id = $cardsOnly->card_id;
                    $userCardsTwo->card_code = preg_replace('# #', '', $request->code);
                    $userCardsTwo->card_code_pw = $request->code_pw;
                    $userCardsTwo->status = 2;
                    $userCardsTwo->number = $cardsOnly->number;
                    $userCardsTwo->number_count = $cardsOnly->number_count;
                    $userCardsTwo->number_last = $cardsOnly->number_last;
                    $userCardsTwo->card_source = 2;

                    $userCardsTwo->save();

                    $cardsOnly = UserCards::where('card_code', preg_replace('# #', '', $request->code))
                        ->where('card_code_pw', $request->code_pw)
                        ->where('status', 1)
                        ->first();
                    $cardsOnly->status = 4;
                    $cardsOnly->save();

                    DB::commit();
                    return response()->json([200, '激活成功!']);
                } catch (Exception $ex) {
                    DB::rollback();
                    return response()->json([401, '激活失败!']);
                    throw $ex;
                }
            }
        }
        return response()->json([401, '激活失败!']);
    }

}