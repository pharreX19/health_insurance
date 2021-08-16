<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\V1\AbstractController;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends AbstractController
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if(!$token = Auth::attempt($credentials)){
            return $this->respondError(['error' => 'Incorrect email or password'], Response::HTTP_UNAUTHORIZED);
        }
        // $permissions = Auth::user()->role->permissions->pluck('slug')->toArray();
        
        if(auth()->user()->serviceProviders()->count() > 1 && !$request['service_provider_id']){
            return $this->respondError([
                'error' => 'No service provider found',
                'service_providers' => auth()->user()->serviceProviders->toArray()
            ], Response::HTTP_CONFLICT);
        }
        
        if(auth()->user()->role_id != 1){
            $_SESSION['serviceProviderId'] = $request['service_provider_id'] ?? auth()->user()->serviceProviders()->first()->value('id');
        }


        // $user = auth()->claims(['foo'=> 'baz'])->attempt($credentials);
        // dd($user);
        $user = Auth::user()->load('role.permissions');
        
        return $this->respondWithToken($token, $user);
    }

    public function logout(Request $request)
    {
        if(isset($_SESSION['serviceProviderId'])){
            unset($_SESSION['serviceProviderId']);
        }
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
            'service_provider' => $_SESSION['serviceProviderId'] ?? null,
            'expires_in' => Auth:: factory()->getTTL() * 60
        ], 'Successfully logged in', Response::HTTP_OK);
    }
}
