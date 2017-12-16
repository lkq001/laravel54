<?php

namespace App\Http\Controllers\Admin;

use App\Model\Banners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use zgldh\QiniuStorage\QiniuStorage;

class BannersController extends Controller
{
    //
    public function index()
    {
        $banners = Banners::get();
        return view('admin.banners.index', [
            'banners' => $banners
        ]);
    }

    // 添加
    public function store(Request $request)
    {
        $banners = new Banners();
        $banners->name = $request->name;
        $banners->status = 1;

        $disk = QiniuStorage::disk('qiniu');

        $path = $disk->put('lvxingzhe', $request->image);

        // 文件是否上传成功
        $banners->image = $path;

        if ($banners->save()) {
            if ($banners->save()) {
                return back();
            }
        }

        if ($banners->save()) {
            return back();
        }
    }

    public function edit(Request $request)
    {
        if (!intval($request->id)) {
            return response()->json([
                'status' => '201',
                'message' => '参数错误!'
            ]);
        }

        $banners = Banners::where('id', $request->id)->first();

        return response()->json([
            'status' => '200',
            'message' => '查询成功!',
            'data' => $banners
        ]);
    }

    public function update(Request $request)
    {
        if (!$request->name || !intval($request->id)) {
            return response()->json([
                'status' => '201',
                'message' => '参数错误!'
            ]);
        }

        $banners = Banners::where('id', $request->id)->first();

        $banners->name = $request->name;

        $disk = QiniuStorage::disk('qiniu');

        $disk->delete($banners->image);

        $path = $disk->put('lvxingzhe', $request->image);

        // 文件是否上传成功
        $banners->image = $path;

        if ($banners->save()) {
            return back();
        }
    }

    public function destroy(Request $request)
    {
        if (!intval($request->id)) {
            return response()->json([
                'status' => '201',
                'message' => '参数错误!'
            ]);
        }
        $banners = Banners::where('id', $request->id)->first();

        if ($banners->delete()) {
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
