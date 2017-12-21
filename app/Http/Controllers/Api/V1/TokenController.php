<?php

namespace App\Http\Controllers\Api\V1;

use App\Service\TokenService;
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

    public function verifyToken($token = '')
    {
        if (!$token) {
            return [
                'code' => '401',
                'msg' => 'token不允许为空',
                'errorCode' => '80000'
            ];
        }
        $valid = TokenService::verifyToken($token);
        return [
            'isValid' => $valid
        ];
    }


}
