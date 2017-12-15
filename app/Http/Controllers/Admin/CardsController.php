<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class CardsController extends Controller
{
    // 卡包列表
    public function index()
    {
        return view('admin.cards.index');
    }
}
