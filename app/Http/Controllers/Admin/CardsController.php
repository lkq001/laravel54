<?php

namespace App\Http\Controllers\Admin;

use App\Model\CardCategorys;
use App\Model\Cards;
use Illuminate\Http\Request;

use zgldh\QiniuStorage\QiniuStorage;
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

        if ($request->image) {

            $disk = QiniuStorage::disk('qiniu');

            $path = $disk->put('lvxingzhe', $request->image);

            // 文件是否上传成功
            $cards->image = $path;
        }

        $cards->save();

        return back();
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

            $disk = QiniuStorage::disk('qiniu');

            $disk->delete($cards->image);

            $path = $disk->put('lvxingzhe', $request->image);

            // 文件是否上传成功
            $cards->image = $path;
        }


        $cards->save();
        return back();
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
