<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\V1\AbstractController;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;

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
            $_SESSION['serviceProviderId'] = $request['service_provider_id'] ?? auth()->user()->serviceProviders()->first();
            //->value('id');
        }


        // $user = auth()->claims(['foo'=> 'baz'])->attempt($credentials);
        // dd($user);
        $user = Auth::user()->load('role.permissions');
        
        return $this->respondWithToken($token, $user);
    }

    public function profile()
    {
        $result = [
            'user' => auth()->user()->load('role.permissions'),
            'service_provider' => $_SESSION['serviceProviderId']->name ?? null
        ];
        return response()->json($result);
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(5)]
        ]);

        if(Hash::check($data['current_password'], Auth::user()->password)){
            $user = Auth::user();
            $user->password = Hash::make($data['password']);
            $user->save();
            return $this->respondSuccess(['data' => $user], "User password updated successfully.", 200);
        }else{
            return $this->respondError("User password update failed, please try again.", 400);
        }
    }

    public function reset(Request $request)
    {
        $user = User::findOrFail($request->user);
        if($user->role_id !== 1){
            $user->password = Hash::make('password');
            $user->save();
            return $this->respondSuccess("User password updated successfully.", 200);
        }
        throw ValidationException::withMessages([
            'message' => 'Cannot reset an admin password.'
        ]);
    }

    public function submitForgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email|email'
        ]);
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
        ]);
        Mail::queue(new ForgotPassword($token));
        return $this->respondSuccess(null, "Please check your inbox, We have e-mailed your password reset link!");
    }

    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatedPassword = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();
        // dd($updatedPassword);
        if(!$updatedPassword){
            throw ValidationException::withMessages([
                'message' => 'Invalid token found'
            ]);
        }

        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        return $this->respondSuccess(null, "Your password has been changed successfully! Please use the password to login");
    }


    public function logout(Request $request)
    {
        if(isset($_SESSION['serviceProviderId'])){
            unset($_SESSION['serviceProviderId']);
        }
        Auth::logout();
        Cache::flush();
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
            'service_provider' => $_SESSION['serviceProviderId']->name ?? null,
            'expires_in' => Auth:: factory()->getTTL() * 60
        ], 'Successfully logged in', Response::HTTP_OK);
    }
}
