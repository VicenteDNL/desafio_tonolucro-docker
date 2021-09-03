<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(RegisterUserRequest $request){

        $credenciais = $request->all();
        $usuario = User::create([
            'name' => $credenciais['name'],
            'email' => $credenciais['email'],
            'password' => Hash::make($credenciais['password']),
        ]);

        $token = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(LoginUserRequest $request){

        $credenciais = $request->all();
        if (!Auth::attempt($credenciais)) {
            return response()->json([
                'message' => 'Login inválido'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json( [
            'message' => 'Tokens Revogados'
        ]);

    }

    public function me(Request $request){
        return $request->user();
    }
}
