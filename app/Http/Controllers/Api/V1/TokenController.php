<?php

namespace App\Http\Controllers\Api\V1;

use app\Service\UserTokenService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TokenController extends Controller
{
    //
    public function getToken(Request $request)
    {
        $this->validate($request, [
            'js_code' => 'required',
        ]);

        $userToken = new UserTokenService($request->js_code);

        $token = $userToken->get();

        return $token;
    }
}
