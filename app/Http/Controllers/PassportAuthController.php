<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class PassportAuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',

        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $token = $user->createToken('passport')->accessToken;
        return response()->json([
            'message' => 'User successfully registered',
            'token' => $token,
            'user' => $user
        ]);
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = auth()->user();
            $token = $user->createToken('passport')->accessToken;
            return response()->json([
                'message' => 'User successfully logged in',
                'token' => $token,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'error' => 'Unauthorised, invalid email or password',
            ]);
        }

    }
    public function logout(Request $request)
    {
        auth()->user()->token()->revoke();
        return response()->json([
            'status' => 'success',
            'message' => 'User successfully logged out',
        ]);

    }
}
