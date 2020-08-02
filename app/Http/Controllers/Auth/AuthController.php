<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
     /**
     * @param ServerRequestInterface $request
     * @return \Illuminate\Support\Collection|mixed
     */
    public function auth(ServerRequestInterface $request)
    {
        $tokenResponse = parent::issueToken($request);
        $token = $tokenResponse->getContent();

        $tokenInfo = json_decode($token, true);

        return $tokenInfo;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('web')->user();

            $token = $user->createToken($user->email . '-' . now());

            return response()->json([
                'user' => $user,
                // 'token' => $token->token->getQueueableId(),
                'token' => $token->accessToken
            ]);
        }
    }
}
