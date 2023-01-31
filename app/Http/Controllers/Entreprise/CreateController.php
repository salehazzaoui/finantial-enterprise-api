<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Http\Resources\EntrepriseResource;
use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CreateController extends Controller
{
    public function store(Request $request)
    {
        $user = User::find(auth()->id());
        $this->fieldsValidation($request);
        $slug = Str::slug($request->name);
        $entreprise = new Entreprise();
        $entreprise->name = $request->name;
        $entreprise->owner_id = $user->id;
        $entreprise->slug = $slug;
        $entreprise->save();

        $user->companies()->attach($entreprise->id);

        return new EntrepriseResource($entreprise);
    }

    private function fieldsValidation(Request $request): void
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255', 'unique:' . Entreprise::class]
        ]);
    }
}
