<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            "email"=> $this->email,
            "profile_picture"=>$this->profile_picture,
            "bio"=>$this->bio,
            "phone"=>$this->phone,
            "address"=>$this->address,
            "country"=>$this->country,
            "city"=>$this->city
        ];
    }
}
