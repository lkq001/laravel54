<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Cards;
use App\Model\CardUse;
use Illuminate\Http\Request;

class CardUseController extends Controller
{
    protected static $cardUse;
    protected static $cards;

    public function __construct(
        CardUse $cardUse,
        Cards $cards
    )
    {
        self::$cardUse = $cardUse;
        self::$cards = $cards;
    }

    //
    public function index(Request $request)
    {
        $useCards = self::$cardUse->where('status', '>', '0')->orderBy('use_time')->paginate(10);

        return view('admin.cardUse.index', [
            'useCards' => $useCards
        ]);
    }
}
