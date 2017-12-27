<?php

namespace App\Http\Controllers\Admin;

use App\Model\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class AreaController extends Controller
{
    protected static $area;

    public function __construct(Area $area)
    {
        self::$area = $area;
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|int'
        ]);

        if ($validator->fails()) {
            return back();
        }

        // 查询
        $areas = self::$area->where('pid', $request->id)->paginate('10');


        return view('admin.area.index', [
            'areaLists' => $areas,
            'pids' => $request->id
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
        $area = new Area();
        $area->pid = $request->pid;
        $area->name = $request->name;
        if ($area->save()) {
            return back();
        }
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
        $area = self::$area->where('id', $request->id)->first();

        $area->name = $request->name;

        if ($area->save()) {
            return back();
        }
        return back();
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
        $area = self::$area->where('id', $request->id)
            ->where('status', $request->status)
            ->first();

        if ($request->status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }

        $area->status = $status;

        if ($area->save()) {
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
        $area = self::$area->where('id', $request->id)
            ->first();

        if ($area->delete()) {
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
}
