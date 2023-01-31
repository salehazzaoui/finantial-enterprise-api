<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function filterEntrepriseTransactions(Request $request)
    {
        $query = (new Entreprise())->newQuery();
        //dd($query);
        $query->join('transactions', 'entreprises.id', '=', 'transactions.entreprise_id')
            ->join('users', 'entreprises.id', '=', 'entreprises.owner_id')
            ->select('entreprises.name', 'users.username', 'transactions.*');
        if ($request->type === 'ADD') {
            $query->where('type', 'ADD');
        } else {
            $query->where('type', 'MINUS');
        }
        if ($request->orderBy === 'latest') {
            $query->latest();
        } else {
            $query->oldest();
        }
        $transactions = $query->get();

        return response()->json([
            'transaction' => $transactions
        ], 200);
    }
}
