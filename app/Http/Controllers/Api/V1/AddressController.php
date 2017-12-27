<?php

namespace App\Http\Controllers\Api\V1;

use App\Model\Address;
use App\Model\Area;
use App\Model\City;
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
        $addressLists = self::$address->where('status', 1)
            ->orderBy('id')->get();

        $address = [];
        if ($addressLists) {
            foreach ($addressLists as $value) {
                $address[] = $value->name;
            }
        }

        return $address;
    }

    //
    public function city(Request $request)
    {
        $addressLists = self::$address->where('status', 1)
            ->orderBy('id')->first();

        $citys = [];

        if ($addressLists) {
            $citysLists = self::$citys->where('pid', $addressLists->id)
                ->where('status', 1)
                ->orderBy('id')->get();
        }


        if ($citysLists) {
            foreach ($citysLists as $value) {
                $citys[] = $value->name;
            }
        }

        return $citys;
    }

    public function area(Request $request)
    {
        // 默认
        $addressInfo = self::$address->where('status', 1)
            ->orderBy('id')->first();

        if (!$addressInfo) {
            return [
                'code' => '404',
                'msg' => '省份不存在',
                'errorCode' => '80000'
            ];
        }

        // 城市
        $cityInfo = self::$citys->where('pid', $addressInfo->id)
            ->where('status', 1)
            ->orderBy('id')->first();

        if (!$cityInfo) {
            return [
                'code' => '404',
                'msg' => '城市不存在',
                'errorCode' => '80000'
            ];
        }

        $areaLists = self::$areas->where('pid', $cityInfo->id)
            ->where('status', 1)
            ->orderBy('id')->get();

        $areas = [];
        if ($areaLists) {
            foreach ($areaLists as $value) {
                $areas[] = $value->name;
            }
        }

        return $areas;
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

}
