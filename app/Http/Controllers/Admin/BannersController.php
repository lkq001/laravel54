<?php

namespace App\Http\Controllers\Admin;

use App\Model\Banners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

class BannersController extends Controller
{
    //
    public function index()
    {
        $banners = Banners::get();
        return  view('admin.banners.index', [
            'banners' => $banners
        ]);
    }

    // 添加
    public function store(Request $request)
    {
        $banners = new Banners();
        $banners->name = $request->name;
        $banners->status = 1;

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
                $banners->image = $filename;
            }
        }

        if ($banners->save()) {
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
                    $banners->image = $filename;
                }
            }
        }

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
