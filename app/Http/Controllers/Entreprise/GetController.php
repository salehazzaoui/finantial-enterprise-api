<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Http\Resources\EntrepriseResource;
use App\Models\Entreprise;
use Illuminate\Http\Request;

class GetController extends Controller
{
    public function getAllEntreprises()
    {
        $entreprises = Entreprise::with(['owner', 'membres'])->get();
        return EntrepriseResource::collection($entreprises);
    }

    public function getEntreprise($id)
    {
        $entreprise = Entreprise::with(['owner', 'membres'])->findOrFail($id);
        return new EntrepriseResource($entreprise);
    }
}
