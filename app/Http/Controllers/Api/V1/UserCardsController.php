<?php

namespace App\Http\Controllers\Api\V1;

use App\Model\CardUse;
use App\Model\UserCards;
use App\Service\TokenService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;

class UserCardsController
{
    public function getCardsHas()
    {
        $uid = TokenService::getCurrnentUid();
        if (!$uid) {
            return false;
        }

        $cards = DB::table('user_cards')
            ->join('cards', 'user_cards.number', '=', 'cards.number')
            ->where('user_cards.user_id', $uid)
            ->where('user_cards.status', 2)
            ->get();
        if (collect($cards)->count() > 0) {
            foreach ($cards as $value) {
                $value->image = config('filesystems.disks.qiniu.domains.default') . '/' . $value->image;
            }
        }
        return $cards;
    }

    public function getNoOpenCardsHas(Request $request)
    {
        $uid = TokenService::getCurrnentUid();
        if (!$uid) {
            return false;
        }

        $cards = DB::table('user_cards')
            ->join('cards', 'user_cards.number', '=', 'cards.number')
            ->where('user_cards.user_id', $uid)
            ->where('user_cards.status', 1)
            ->get();

        if (collect($cards)->count() > 0) {
            foreach ($cards as $value) {
                $value->image = config('filesystems.disks.qiniu.domains.default') . '/' . $value->image;
            }
        }
        return $cards;
    }

    public function openCardsHas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'code' => 'required',
            'code_pw' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([401, '参数错误']);
        }

        $uid = TokenService::getCurrnentUid();
        if (!$uid) {
            return false;
        }

        // 查询此宅配卡
        $cards = UserCards::where('user_id', $uid)
            ->where('card_code', $request->code)
            ->where('card_code_pw', $request->code_pw)
            ->where('status', 1)
            ->first();


        if (collect($cards)->count() > 0) {
            $cards->user_id = $uid;
            $cards->status = 2;

            if ($cards->save()) {
                return response()->json([200, '开通成功']);
            }
        }

        return response()->json([401, '开通失败']);
    }

    public function canUseCards()
    {
        $uid = TokenService::getCurrnentUid();
        if (!$uid) {
            return false;
        }

        $cards = DB::table('user_cards')
            ->select('user_cards.id', 'user_cards.address', 'user_cards.card_code', 'cards.image')
            ->join('cards', 'user_cards.number', '=', 'cards.number')
            ->where('user_cards.user_id', $uid)
            ->where('user_cards.status', 2)
            ->get();

        if (collect($cards)->count() > 0) {
            foreach ($cards as $value) {
                $value->image = config('filesystems.disks.qiniu.domains.default') . '/' . $value->image;
                if (mb_strlen($value->address) > 6) {
                    $value->address = mb_substr($value->address, 0, 6, 'utf-8') . '...';
                } else {
                    $value->address = mb_substr($value->address, 0, 6, 'utf-8');
                }

            }
        }
        return $cards;
    }

    public function canUseCardsInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json([401, '参数错误']);
        }

        $uid = TokenService::getCurrnentUid();
        if (!$uid) {
            return false;
        }

        // 查询此宅配卡
        $cards = UserCards::where('user_id', $uid)
            ->where('id', $request->id)
            ->where('status', 2)
            ->first();

        if (!$cards->address) {
            $cards->address = "暂无地址";
        }

        return $cards;

    }

    public function useCardByUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cardsCount' => 'required|int',
            'useTime' => 'required',
            'countNo' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json([401, '参数错误']);
        }

        $uid = TokenService::getCurrnentUid();
        if (!$uid) {
            return false;
        }

        // 查询改用户是否存在
        $userCard = UserCards::where('user_id', $uid)
            ->where('card_code', $request->countNo)
            ->where('status', 2)
            ->where('number_last', '>=', $request->cardsCount)
            ->first();

        if (collect($userCard)->count() > 0) {
            // 执行使用逻辑
            DB::beginTransaction();
            try {

                $userCard->number_last = intval($userCard->number_last) - intval($request->cardsCount);
                $userCard->save();

                $cardUser = new CardUse();
                $cardUser->status = 2;
                $cardUser->card_id = $request->countNo;
                $cardUser->card_use = $request->cardsCount;
                $cardUser->status = 1;
                $cardUser->user_id = $uid;
                $cardUser->use_time = $request->useTime;
                $cardUser->save();

                DB::commit();
                return response()->json([200, '提交成功!', $userCard]);
            } catch (Exception $ex) {
                DB::rollback();
                return response()->json([401, '提交失败!']);
                throw $ex;
            }
        }
        return response()->json([401, '信息不存在']);
    }


}
