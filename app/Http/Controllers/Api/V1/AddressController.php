<?php

namespace App\Http\Controllers\Api\V1;

use App\Model\Address;
use App\Model\Area;
use App\Model\City;
use App\Model\Users;
use App\Service\TokenService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class AddressController extends Controller
{
    protected static $address;
    protected static $citys;
    protected static $areas;

    public function __construct(
        Address $address,
        City $city,
        Area $area
    )
    {
        self::$address = $address;
        self::$citys = $city;
        self::$areas = $area;
    }

    //
    public function index(Request $request)
    {
        // 查询该用户的默认地址信息
        $uid = TokenService::getCurrnentUid();
        if (!$uid) {
            return response()->json([401, '用户信息错误']);
        }
        $user = Users::where('id', $uid)->first();
        if (!$user) {
            return response()->json([401, '地址信息错误']);
        }

        $addressLists = self::$address->where('status', 1)
            ->orderBy('id')->get();

        $address = [];
        $keyIndex = 0;
        if ($addressLists) {
            foreach ($addressLists as $key => $value) {
                $address[] = $value->name;
                if ($value->name == $user->province) {
                    $keyIndex = $key;
                }
            }
        }

        return [
            'address' => $address,
            'keyIndex' => $keyIndex
        ];
    }

    //
    public function city(Request $request)
    {
        // 查询该用户的默认地址信息
        $uid = TokenService::getCurrnentUid();
        if (!$uid) {
            return response()->json([401, '用户信息错误']);
        }
        $user = Users::where('id', $uid)->first();
        if (!$user) {
            return response()->json([401, '地址信息错误']);
        }

        if ($user->province) {
            $addressLists = self::$address->where('status', 1)
                ->where('name', $user->province)
                ->orderBy('id')->first();
            if (!$addressLists) {
                $addressLists = self::$address->where('status', 1)
                    ->orderBy('id')->first();
            }
        } else {
            $addressLists = self::$address->where('status', 1)
                ->orderBy('id')->first();

        }

        if ($addressLists) {
            $citysLists = self::$citys->where('pid', $addressLists->id)
                ->where('status', 1)
                ->orderBy('id')->get();
        }


        $citys = [];
        $keyIndex = 0;
        if ($citysLists) {
            foreach ($citysLists as $key => $value) {
                $citys[] = $value->name;
                if ($value->name == $user->city) {
                    $keyIndex = $key;
                }
            }
        }

        return [
            'citys' => $citys,
            'keyIndex' => $keyIndex
        ];
    }

    public function area(Request $request)
    {
        // 查询该用户的默认地址信息
        $uid = TokenService::getCurrnentUid();
        if (!$uid) {
            return response()->json([401, '用户信息错误']);
        }
        $user = Users::where('id', $uid)->first();
        if (!$user) {
            return response()->json([401, '地址信息错误']);
        }

        if ($user->province) {
            $addressInfo = self::$address->where('status', 1)
                ->where('name', $user->province)
                ->orderBy('id')->first();
            if (!$addressInfo) {
                $addressInfo = self::$address->where('status', 1)
                    ->orderBy('id')->first();
            }
        } else {
            $addressInfo = self::$address->where('status', 1)
                ->orderBy('id')->first();

        }

        if (!$addressInfo) {
            return response()->json([401, '地址信息错误']);
        }
        if ($user->city) {
            // 城市
            $cityInfo = self::$citys->where('pid', $addressInfo->id)
                ->where('name', $user->city)
                ->where('status', 1)
                ->orderBy('id')->first();
            if (!$cityInfo) {
                // 城市
                $cityInfo = self::$citys->where('pid', $addressInfo->id)
                    ->where('status', 1)
                    ->orderBy('id')->first();
            }
        } else {
            // 城市
            $cityInfo = self::$citys->where('pid', $addressInfo->id)
                ->where('status', 1)
                ->orderBy('id')->first();
        }


        if (!$cityInfo) {
            return response()->json([401, '城市信息错误']);
        }

        $areaLists = self::$areas->where('pid', $cityInfo->id)
            ->where('status', 1)
            ->orderBy('id')->get();

        $areas = [];
        $keyIndex = 0;
        if ($areaLists) {
            foreach ($areaLists as$key =>  $value) {
                $areas[] = $value->name;
                if ($value->name == $user->area) {
                    $keyIndex = $key;
                }
            }
        }

        return [
            'areas' => $areas,
            'keyIndex' => $keyIndex
        ];
    }


    public function cityByName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([401, $validator->errors()->first()]);
        }

        $addressInfo = self::$address->where('name', $request->name)->first();

        if (!$addressInfo) {
            return response()->json([401, '您选择省份不存在']);
        }

        $citys = [];

        $citysLists = self::$citys->where('pid', $addressInfo->id)
            ->where('status', 1)
            ->orderBy('id')->get();

        if ($citysLists) {
            foreach ($citysLists as $value) {
                $citys[] = $value->name;
            }
        }

        $citysListsArray = collect($citysLists)->toArray();

        $areas = [];
        // 选择第一个城市的id, 查询区域
        $areasLists = self::$areas->where('pid', $citysListsArray['0']['id'])->orderBy('id')->get();

        if ($areasLists) {
            foreach ($areasLists as $value) {
                $areas[] = $value->name;
            }
        }

        $data = [
            'citys' => $citys,
            'areas' => $areas
        ];

        return $data;
    }

    public function areaByName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([401, $validator->errors()->first()]);
        }

        $cityInfo = self::$citys->where('name', $request->name)
            ->where('status', 1)
            ->orderBy('id')->first();

        $areas = [];
        // 选择第一个城市的id, 查询区域
        $areasLists = self::$areas->where('pid', $cityInfo->id)->orderBy('id')->get();

        if ($areasLists) {
            foreach ($areasLists as $value) {
                $areas[] = $value->name;
            }
        }

        return $areas;
    }

    public function getUserInfo()
    {
        // 查询该用户的默认地址信息
        $uid = TokenService::getCurrnentUid();
        if (!$uid) {
            return response()->json([401, '用户信息错误']);
        }
        $user = Users::where('id', $uid)->first();
        if ($user) {
            return $user;
        }
        return response()->json([401, '用户信息错误']);
    }

}
