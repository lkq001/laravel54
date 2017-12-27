<?php

namespace App\Http\Controllers\Admin;

use App\Model\Address;
use App\Model\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CityController extends Controller
{
    protected static $city;
    protected static $address;

    public function __construct(City $city, Address $address)
    {
        self::$city = $city;
        self::$address = $address;
    }

    //
    public function index(Request $request)
    {
        // 查询所有省份
        $addressLists = self::$address->orderBy('id')->get();

        if ($request->id) {
            $id = $request->id;
        } else {
            // 查询默认的第一个
            $address = self::$address->where('status', 1)->first();
            $id = $address->id;
        }

        $cityLists = self::$city->where('pid', $id)->orderBy('id')->paginate('10');

        return view('admin.city.index', [
            'addressLists' => $addressLists,
            'cityLists' => $cityLists,
            'id' => $id
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'pid' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json([401, $validator->errors()->first()]);
        }

        // 执行添加
        $city = new City();
        $city->pid = $request->pid;
        $city->name = $request->name;
        if ($city->save()) {
            return back();
        }
    }

    public function status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json([401, $validator->errors()->first()]);
        }

        // 执行状态修改
        $city = self::$city->where('id', $request->id)
            ->where('status', $request->status)
            ->first();

        if ($request->status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }

        $city->status = $status;

        if ($city->save()) {
            return response()->json([
                'status' => '200',
                'message' => '修改成功!'
            ]);
        }
        return response()->json([
            'status' => '201',
            'message' => '修改失败!'
        ]);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([401, $validator->errors()->first()]);
        }

        // 执行状态修改
        $city = self::$city->where('id', $request->id)
            ->first();

        if ($city->delete()) {
            return response()->json([
                'status' => '200',
                'message' => '修改成功!'
            ]);
        }
        return response()->json([
            'status' => '201',
            'message' => '修改失败!'
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'pid' => 'required|int',
            'name' => 'required'
        ]);


        if ($validator->fails()) {
            return back();
        }

        // 执行状态修改
        $city = self::$city->where('id', $request->id)->first();

        $city->name = $request->name;
        $city->pid = $request->pid;

        if ($city->save()) {
            return back();
        }
        return back();
    }

}
