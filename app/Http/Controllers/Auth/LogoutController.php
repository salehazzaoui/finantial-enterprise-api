<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function destroy(): JsonResponse
    {
        $user = User::find(auth()->id());
        $user->tokens()->delete();

        return response()->json(['message' => trans('messages.logout')], 200);
    }
}
