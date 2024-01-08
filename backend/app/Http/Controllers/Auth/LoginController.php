<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\AuthLoginStoreRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function __invoke(AuthLoginStoreRequest $request)
    {

        $data = $request->validated();
        $credentials =  ['email' => $data['email'], 'password' => $data['password']];

        if(!auth()->attempt($credentials)){
            return response()->json(['email' => 'invalid']);
        }
        $request->session()->regenerate();

        $token = session()->get('_token');

        $user = auth()->user();

        return response()->json(['mess' => 1, 'user' => $user, 'token' => $token]);


    }

}
