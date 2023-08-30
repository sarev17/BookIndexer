<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getToken(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken();
            $user->update(['api_token'=>$token]);
            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Não autorizado'], 401);
    }
}
