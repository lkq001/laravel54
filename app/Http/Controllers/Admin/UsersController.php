<?php

namespace App\Http\Controllers\Admin;

use App\Model\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    //
    public function index()
    {
        $users = Users::paginate(2);
        return view('admin.users.index', [
            'users' => $users
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
        if (!$request->name) {
            return response()->json([
                'status' => '201',
                'message' => '分类名称不能为空!'
            ]);
        }

        $users = new Users();
        $users->name = $request->name;

        if ($users->save()) {
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

        $users = Users::where('id', $request->id)->first();

        return response()->json([
            'status' => '200',
            'message' => '查询成功!',
            'data' => $users
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
        if (!$request->name || !intval($request->id)) {
            return response()->json([
                'status' => '201',
                'message' => '参数错误!'
            ]);
        }

        $users = Users::where('id', $request->id)->first();
        $users->name = $request->name;

        if ($users->save()) {
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
        $users = Users::where('id', $request->id)->first();

        if ($users->delete()) {
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
