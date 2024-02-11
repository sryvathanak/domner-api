<?php

namespace App\Http\Resources\Address;

use App\Http\Resources\Stay\StayResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResorce extends JsonResource
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
            'country' => $this->country,
            'province' => $this->province,
            'city' => $this->city,
            'total_stay' => $this->getAllStay->count(),
            'stay' => StayResource::collection($this->getAllStay)

        ];
    }
}
