<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Attempt logging in
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'The credentials does not match our records.'
            ], 404);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'user' => ['name' => $user->name, 'email' => $user->email],
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function user()
    {
        $user = Auth::user();

        return response()->json([
            'access_token' => $user->token()->id,
            'token_type' => 'Bearer',
            'user' => ['name' => $user->name, 'email' => $user->email],
        ]);
    }
}
