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
     * @return json response message 
     */
    public function signup(Request $request){
        $this->validateSignUpData($request);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

        
    /**
     * login
     *
     * @param  mixed $request
     * @return json response
     */
    public function login(Request $request){
        $this->validateLoginData($request);

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
     * @return json response
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
    

    /**
     * validateSignUpData
     *
     * @param  mixed $request
     * @return void
     */
    public function validateSignUpData(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
    }
    
    /**
     * validateLoginData
     *
     * @param  mixed $request
     * @return void
     */
    public function validateLoginData(Request $request){ 
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
    }

}
