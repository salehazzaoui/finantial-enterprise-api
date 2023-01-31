<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\UserResource;
use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class AdminController extends Controller
{

    public function addUserToEntreprise($entrepriseId, $userId)
    {
        $user = User::findOrFail($userId);
        $isParticipant = $user->companies()->where('entreprise_id', $entrepriseId)->exists();
        if ($isParticipant) {
            return response()->json([
                'message' => trans('messages.user_already_existe')
            ], 402);
        }
        $user->companies()->attach($entrepriseId);

        return response()->json([
            'message' => trans('messages.user_added_to_entreprise')
        ]);
    }

    public function searchUser(Request $request)
    {
        $q = $request->query('q');
        $users = User::where('first_name', 'like', '%' . $q . '%')
            ->orWhere('last_name', 'like', '%' . $q . '%')
            ->orWhere('username', 'like', '%' . $q . '%')
            ->latest()
            ->get();

        return UserResource::collection($users);
    }

    public function addUser(Request $request)
    {
        $this->validateFields($request);
        $user = new User();
        $user = $this->createUser($request, $user);
        event(new Registered($user));

        return  response()->json([
            'user' => new UserResource($user),
        ], 201);
    }

    public function updateUser(Request $request, $id)
    {
        $this->validateFields($request);
        $user = User::findOrFail($id);
        $user = $this->createUser($request, $user);

        return  response()->json([
            'user' => new UserResource($user),
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
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }

    private function createUser(Request $request, User $user): User
    {
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->phone_numbre = $request->phone_numbre;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return  response()->json([
            'message' => trans('messages.user_deleted'),
        ], 200);
    }
}
