<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'phone' => $this->phone_numbre,
            'email' => $this->email,
            'transactions' => TransactionResource::collection($this->transactions),
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
