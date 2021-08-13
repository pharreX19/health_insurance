<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\V1\AbstractController;
use Illuminate\Http\Response;

class AuthController extends AbstractController
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if(!$token = Auth::attempt($credentials)){
            return $this->respondError(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        // $permissions = Auth::user()->role->permissions->pluck('slug')->toArray();
        $user = Auth::user()->load('role.permissions');
        if($user->user_type === 'App\Receptionist'){
            dd(app('App\Models\Receptionist'));
            dd($user->user_type->serviceProvider());
        }
        return $this->respondWithToken($token, $user);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return $this->respondSuccess(null, 'Successfully logged out', Response::HTTP_OK);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    private function respondWithToken(String $token, $user = null){
        return $this->respondSuccess([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
            'expires_in' => Auth:: factory()->getTTL() * 60
        ], 'Successfully logged in', Response::HTTP_OK);
    }
}
