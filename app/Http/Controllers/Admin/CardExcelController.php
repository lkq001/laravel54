<?php

namespace App\Http\Controllers\Admin;

use App\Model\CardExcel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CardExcelController extends Controller
{
    //

    public function index()
    {

        $cardExcel = CardExcel::paginate(2);

        return view('admin.cardExcel.index', [
            'cardExcel' => $cardExcel,
        ]);
    }
}
