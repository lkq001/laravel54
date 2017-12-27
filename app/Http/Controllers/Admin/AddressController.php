<?php

namespace App\Http\Controllers\Admin;

use App\Model\Address;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    protected static $address;

    public function __construct(Address $address)
    {
        self::$address = $address;
    }

    //
    public function index()
    {
        $addressLists = self::$address->orderBy('id')->paginate('10');

        return view('admin.address.index', [
            'addressLists' => $addressLists
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([401, $validator->errors()->first()]);
        }

        // 执行添加
        $address = new Address();
        $address->name = $request->name;
        if ($address->save()) {
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
        $address = self::$address->where('id', $request->id)
            ->where('status', $request->status)
            ->first();

        if ($request->status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }

        $address->status = $status;

        if ($address->save()) {
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
        $address = self::$address->where('id', $request->id)
            ->first();

        if ($address->delete()) {
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
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return back();
        }

        // 执行状态修改
        $address = self::$address->where('id', $request->id)->first();

        $address->name = $request->name;

        if ($address->save()) {
            return back();
        }
        return back();
    }
}
