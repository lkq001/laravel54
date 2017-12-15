<?php

namespace App\Http\Controllers\Admin;

use App\Model\CardCategorys;
use App\Model\Cards;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    // 卡包列表
    public function index()
    {
        $categorys = CardCategorys::get();

        return view('admin.cards.index', [
            'categorys' => $categorys,
        ]);
    }

    // 添加
    public function store(Request $request)
    {
        $cards = new Cards();
        $cards->name = $request->name;
        $cards->description = $request->editorValue;
        $cards->category_id = $request->category_id;
        $cards->image = $request->category_id;
        $cards->price = $request->category_id;
        $cards->status = $request->category_id;
        $cards->number = $request->category_id;
        $cards->number_count = $request->category_id;
        $cards->sales_number = $request->category_id;

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
}
