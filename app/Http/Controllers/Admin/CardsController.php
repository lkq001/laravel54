<?php

namespace App\Http\Controllers\Admin;

use App\Model\CardCategorys;
use App\Model\Cards;
use Illuminate\Http\Request;

use Storage;

class CardsController extends Controller
{
    // 卡包列表
    public function index()
    {
        $categorys = CardCategorys::get();
        $cards = Cards::get();

        return view('admin.cards.index', [
            'categorys' => $categorys,
            'cards' => $cards,
        ]);
    }

    // 添加
    public function store(Request $request)
    {
        $cards = new Cards();
        $cards->name = $request->name;
        $cards->description = $request->editorValue;
        $cards->category_id = $request->category_id;
        $cards->price = $request->price;
        $cards->status = 1;
        $cards->number = $request->number;
        $cards->number_count = $request->number;

        // 图片上传
        $file = $request->file('image');

        // 文件是否上传成功
        if ($file->isValid()) {

            // 获取文件相关信息
            $originalName = $file->getClientOriginalName(); // 文件原名
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $realPath = $file->getRealPath();   //临时文件的绝对路径
            $type = $file->getClientMimeType();     // image/jpeg

            // 上传文件
            $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
            // 使用我们新建的uploads本地存储空间（目录）
            $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));

            if ($bool) {
                $cards->image = $filename;
            }
        }

        if ($cards->save()) {
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

        $cards = Cards::where('id', $request->id)->first();

        return response()->json([
            'status' => '200',
            'message' => '查询成功!',
            'data' => $cards
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

        $cards = Cards::where('id', $request->id)->first();

        $cards->name = $request->name;
        $cards->description = $request->editorValue;
        $cards->category_id = $request->category_id;
        $cards->price = $request->price;
        $cards->status = 1;
        $cards->number = $request->number;
        $cards->number_count = $request->number;

        if ($request->image) {
            // 图片上传
            $file = $request->file('image');

            // 文件是否上传成功
            if ($file->isValid()) {

                // 获取文件相关信息
                $originalName = $file->getClientOriginalName(); // 文件原名
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $type = $file->getClientMimeType();     // image/jpeg

                // 上传文件
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                // 使用我们新建的uploads本地存储空间（目录）
                $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));

                if ($bool) {
                    $cards->image = $filename;
                }
            }
        }

        if ($cards->save()) {
            return back();
        }
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
        $cards = Cards::where('id', $request->id)->first();

        if ($cards->delete()) {
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
