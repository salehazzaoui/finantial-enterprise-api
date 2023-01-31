<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\DiffrentNewPassword;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function editProfile(Request $request)
    {
        $user = User::find(auth()->id());
        $this->validateFields($request);
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'phone_numbre' => $request->phone_numbre,
            'email' => $request->email,
        ]);

        return response()->json([
            'message' => trans('messages.information_updated')
        ], 200);
    }

    private function validateFields(Request $request): void
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'phone_numbre' => ['required', 'numeric', 'min:10', 'unique:' . User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            //'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = User::find(auth()->id());
        $request->validate([
            'old_password' => ['required', 'string', new MatchOldPassword($user)],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), new DiffrentNewPassword($user)],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => trans('messages.password_updated')
        ], 200);
    }
}
