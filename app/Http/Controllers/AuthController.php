<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! $token = auth()->attempt($credentials)) {
            $response = [
                'success' => false,
                'data'    => $request['email'],
                'message' => 'Login não realizado'
            ];

            return response()->json($response, 404);
        }

        $success = $this->respondWithToken($token);

        $response = [
            'success' => true,
            'data'    => $success,
            'message' => 'Login realizado com sucesso.'
        ];

        return response()->json($response, 200);
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL()
        ];
    }
}
