<?php

namespace App\Http\Controllers\Api\V1;

use App\Model\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class AddressController extends Controller
{
    protected static $address;

    public function __construct(Address $address)
    {
        self::$address = $address;
    }

    //
    public function index(Request $request)
    {
        $addressLists = self::$address->where('pid', 0)
            ->where('status', 1)
            ->orderBy('id')->get();
        $address  = [];
        if ($addressLists) {
            foreach ($addressLists as $value) {
                $address[] = $value->province;
            }
        }

        return $address;
    }

    //
    public function city(Request $request)
    {
        $addressLists = self::$address->where('pid', 0)
            ->where('status', 1)
            ->orderBy('id')->first();

        $citys  = [];

        if ($addressLists) {
            $citysLists = self::$address->where('pid', $addressLists->id)
                ->where('status', 1)
                ->orderBy('id')->get();
        }


        if ($citysLists) {
            foreach ($citysLists as $value) {
                $citys[] = $value->province;
            }
        }

        return $citys;
    }

    public function cityByName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([401, $validator->errors()->first()]);
        }

        $addressInfo = self::$address->where('province', $request->name)->first();

        if (!$addressInfo) {
            return response()->json([401, '您选择省份不存在']);
        }

        $citys  = [];

        $citysLists = self::$address->where('pid', $addressInfo->id)
            ->where('status', 1)
            ->orderBy('id')->get();

        if ($citysLists) {
            foreach ($citysLists as $value) {
                $citys[] = $value->province;
            }
        }

        return $citys;
    }

}
