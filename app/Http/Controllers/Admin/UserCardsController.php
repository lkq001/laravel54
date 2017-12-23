<?php

namespace App\Http\Controllers\Admin;

use App\Model\UserCards;
use App\Service\TokenService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserCardsController extends Controller
{
    //
    public function index()
    {
        $userCards = UserCards::paginate(10);

        return view('admin.userCards.index', [
            'userCards' => $userCards
        ]);
    }


}
