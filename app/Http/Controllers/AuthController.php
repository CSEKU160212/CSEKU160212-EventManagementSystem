<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;

class AuthController extends Controller
{
        
    /**
     * signup
     *
     * @param  mixed $request
     * @return Illuminate\Http\Response 
     */
    public function signup(Request $request){
        
        $request->validate([
            'name' => 'required|string',
            'contact_no' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'address' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User([
            'name' => $request->name,
            'contact_no' => $request->contact_no,
            'email' => $request->email,
            'address' => $request->address,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }

        
    /**
     * login
     *
     * @param  mixed $request
     * @return Illuminate\Http\Response
     */
    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        
        $token->save();
        
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
      
    /**
     * logout
     *
     * @param  mixed $request
     * @return Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
      
    /**
     * user
     *
     * @param  mixed $request
     * @return user
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }


}
