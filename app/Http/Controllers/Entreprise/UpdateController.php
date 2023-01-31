<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Http\Resources\EntrepriseResource;
use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class UpdateController extends Controller
{
    public function update(Request $request, $id)
    {
        $entreprise = Entreprise::findOrfail($id);
        $this->fieldsValidation($request);
        Gate::authorize('update', $entreprise);

        $entreprise->name = $request->name;
        $entreprise->slug = Str::slug($request->name);
        $entreprise->save();
        return new EntrepriseResource($entreprise);
    }

    private function fieldsValidation(Request $request): void
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255', 'unique:' . Entreprise::class]
        ]);
    }
}
