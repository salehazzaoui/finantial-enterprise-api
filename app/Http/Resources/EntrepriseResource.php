<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EntrepriseResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'owner' => [
                'id' => $this->owner->id,
                'first_name' => $this->owner->first_name,
                'last_name' => $this->owner->last_name,
                'username' => $this->owner->username
            ],
            'amounts' => [
                'amount_entre' => $this->amount_entre,
                'amount_out' => $this->amount_out,
                'amount_between' => abs($this->amount_entre - $this->amount_out),
            ],
            'transactions' => TransactionResource::collection($this->transactions),
            'participants' => UserResource::collection($this->membres),
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
