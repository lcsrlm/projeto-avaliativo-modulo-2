<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthControler extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                return $this->error('Não autorizado. Credenciais inválidas', Response::HTTP_UNAUTHORIZED);
            }

            $token = $request->user()->createToken('authToken', ['expires_in' => 1440]);

            return response()->json([
                'message' => 'Autorizado',
                'token' => $token->plainTextToken,
            ], Response::HTTP_CREATED);
        }  catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->response('', Response::HTTP_NO_CONTENT);
    }
}
