<?php

namespace App\Http\Controllers\Api\V1;

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


}
