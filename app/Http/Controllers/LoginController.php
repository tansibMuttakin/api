<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
    }
    public function login(Request $request){
        $credentials = $request->only(['email','password']);
        $token = Auth::attempt($credentials);
        if (! $token) {
            return response()->json(['error' => 'Incorrect Email/Password'], 401);
        }
        return response()->json(['token' => $token], 200);
    }
}
