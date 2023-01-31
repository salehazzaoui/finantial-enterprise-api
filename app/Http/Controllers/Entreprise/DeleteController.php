<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Gate;

class DeleteController extends Controller
{
    public function destroy($id)
    {
        $entreprise = Entreprise::findOrFail($id);
        Gate::authorize('delete', $entreprise);
        $entreprise->delete();

        return response()->json([
            'message' => trans('messages.entreprise_deleted')
        ], 200);
    }
}
