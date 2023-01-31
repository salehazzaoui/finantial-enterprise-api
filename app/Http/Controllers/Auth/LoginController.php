<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function store(Request $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => trans('messages.user_not_found')
            ], 404);
        }
        if ($this->isValidFields($request, $user) === false)
            return response()->json([
                'message' => trans('messages.login_credential')
            ], 422);

        /*if ($this->isUserEmailVefified($user) === false)
            return response()->json([
                'message' => trans('messages.must_verify_email'),
                'status' => 401
            ], 401);
        */
        $token = $user->createToken($request->email)->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    private function isValidFields(Request $request, User $user)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        return !$user || Hash::check($request->password, $user->password);
    }

    private function isUserEmailVefified(User $user)
    {
        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) return false;
        return true;
    }
}
