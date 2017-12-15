<?php

namespace App\Http\Controllers\Admin;

use App\Model\CardCategorys;
use Illuminate\Http\Request;

class CardCategorysController extends Controller
{
    /**
     * 卡包列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 李克勤
     */
    public function index()
    {
        $cardCategorys = CardCategorys::paginate(2);

        return view('admin.cardCategory.index', [
            'cardCategorys' => $cardCategorys
        ]);
    }

    /**
     * 卡包执行添加
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

        $cardCategorys = new CardCategorys();
        $cardCategorys->name = $request->name;

        if ($cardCategorys->save()) {
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
     * 宅配卡编辑
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

        $cardCategory = CardCategorys::where('id', $request->id)->first();

        return response()->json([
            'status' => '200',
            'message' => '查询成功!',
            'data' => $cardCategory
        ]);
    }

    /**
     * 执行编辑
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

        $cardCategorys = CardCategorys::where('id', $request->id)->first();
        $cardCategorys->name = $request->name;

        if ($cardCategorys->save()) {
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
        $cardCategorys = CardCategorys::where('id', $request->id)->first();

        if ($cardCategorys->delete()) {
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
