<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\TypeTransactionRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function store(Request $request, $entrepriseId): JsonResponse
    {
        $this->fieldsValidation($request);

        $user = User::find(auth()->id());
        $isUserParticipantOnEntreprise = $user->companies()->exists();
        if (!$isUserParticipantOnEntreprise) {
            return response()->json([
                'message' => trans('messages.not_participant')
            ]);
        }

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'entreprise_id' => $entrepriseId,
            'type' => $request->type,
            'amount' => $request->amount,
        ]);

        if ($transaction) {
            $entreprise = Entreprise::find($transaction->entreprise_id);
            if ($transaction->type === 'ADD') {
                $entreprise->update([
                    'amount_entre' => $entreprise->amount_entre + $transaction->amount
                ]);
            } else {
                $entreprise->update([
                    'amount_entre' => $entreprise->amount_entre - $transaction->amount,
                    'amount_out' => $entreprise->amount_out + $transaction->amount
                ]);
            }
        }

        return response()->json([
            'message' => 'transaction pushed successfully.',
            'transaction' => $transaction
        ], 201);
    }

    private function fieldsValidation(Request $request): void
    {
        $this->validate($request, [
            'type' => ['required', 'string', 'max:255', new TypeTransactionRule],
            'amount' => ['required', 'numeric'],
        ]);
    }
}
