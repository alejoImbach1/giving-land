<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\error;

class AuthController extends Controller
{
    //
    public function login(LoginRequest $request)
    {
        if (auth()->check()){
            return response()->json(['message' => 'ya hay un usuario autenticado'],403);
        }
        if (!Auth::attempt($request->only(['email', 'password']))) {
            $message = 'El correo electrónico o la contraseña son incorrectos.';
            $errors = ['email' => $message];
            return response()->json(compact('message','errors'),401);
        }
        // $request->session()->regenerate();
        $user = User::where('email',$request->email)->firstOrFail();
        $auth_token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(compact('user','auth_token'));
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Se ha cerrado sesión'
        ]);
    }
}
