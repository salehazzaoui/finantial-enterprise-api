<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->user->username,
            'entreprise' => $this->entreprise->name,
            'type' => $this->type,
            'amount' => $this->amount,
            'created_at' => [
                'normal' => $this->created_at,
                'human' => $this->created_at->diffForHumans()
            ],
            'updated_at' => [
                'normal' => $this->updated_at,
                'human' => $this->updated_at->diffForHumans()
            ]
        ];
    }
}
