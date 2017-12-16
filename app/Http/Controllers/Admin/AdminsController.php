<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admins;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class AdminsController extends Controller
{
    //
    public function index()
    {
        $admins = Admins::paginate(2);
        return view('admin.admins.index', [
            'admins' => $admins
        ]);
    }

    /**
     * 添加
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function store(Request $request)
    {

        if (!$request->username || !$request->password) {
            return response()->json([
                'status' => '201',
                'message' => '提交信息有误!'
            ]);
        }

        if (Admins::where('username', $request->username)->first()) {
            return response()->json([
                'status' => '201',
                'message' => '用户名已经存在!'
            ]);
        }

        $admins = new Admins();

        $admins->username = $request->username;
        $admins->password = Crypt::encrypt($request->password);

        if ($admins->save()) {
            return response()->json([
                'status' => '200',
                'message' => '添加成功!'
            ]);
        }

        return response()->json([
            'status' => '201',
            'message' => '添加失败!'
        ]);
    }

    /**
     * 编辑
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function edit(Request $request)
    {
        if (!intval($request->id)) {
            return response()->json([
                'status' => '201',
                'message' => '参数错误!'
            ]);
        }

        $admins = Admins::where('id', $request->id)->first();

        return response()->json([
            'status' => '200',
            'message' => '查询成功!',
            'data' => $admins
        ]);
    }

    /**
     * 保存
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function update(Request $request)
    {
        if (!$request->username || !$request->password || !intval($request->id)) {
            return response()->json([
                'status' => '201',
                'message' => '参数错误!'
            ]);
        }

        $admins = Admins::where('id', $request->id)->first();
        $admins->username = $request->username;
        $admins->password = Crypt::encrypt($request->password);

        if ($admins->save()) {
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

    /**
     * 删除
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function destroy(Request $request)
    {
        if (!intval($request->id)) {
            return response()->json([
                'status' => '201',
                'message' => '参数错误!'
            ]);
        }
        $admins = Admins::where('id', $request->id)->first();

        if ($admins->delete()) {
            return response()->json([
                'status' => '200',
                'message' => '删除成功!'
            ]);
        }
        return response()->json([
            'status' => '201',
            'message' => '删除失败!'
        ]);
    }

}
