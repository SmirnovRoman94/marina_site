<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\AuthStoreRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

//use Laravel\Sanctum\PersonalAccessToken;

class RegisterController extends Controller
{
    public function __invoke(AuthStoreRequest $request)
    {

        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::where('email', $data['email'])->first();
        if($user) return response(['mess' => 1]);

        $user = User::create($data);
        $token = auth()->tokenById($user -> id);
        return response(['mess' => 2, 'access_token' => $token]);

//        $user = User::firstOrCreate($data);
//
//        $credentials =  ['email' => $user->email, 'password' => $data['password'] ];
//
//        if(!auth()->attempt($credentials)){
//            return response()->json(['mess' => 'Ошибка входа в систему']);
//        }
//        $request->session()->regenerate();
//        $token = session()->get('_token');
//        return response()->json( ['mess' => 1, 'data' => auth()->user(), 'token' => $token], 201);


    }

}
