<?php

namespace App\Http\Controllers\Api\V1;

use App\Service\UserTokenService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TokenController extends Controller
{
    //
    public function getToken(Request $request)
    {

        $this->validate($request, [
            'code' => 'required',
        ]);

        $userToken = new UserTokenService($request->code);

        $token = $userToken->get();

        return [
            'token' => $token
        ];
    }
}
