<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'country' => $this->country->name,
            'account_id' => $this->account_id,
            'created_at' => $this->created_at->format('d.m.Y. H:m:s'),
            'updated_at' => $this->updated_at->format('d.m.Y. H:m:s'),
        ];
    }
}
