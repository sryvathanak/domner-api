<?php

namespace App\Http\Resources\Stay;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $room_images = is_array($this->room_images) ? $this->room_images : [$this->room_images];
        $hotel_images = is_array($this->hotel_images) ? $this->hotel_images : [$this->hotel_images];
        $address =$this -> getAddress -> country . ' ' . $this -> getAddress -> province . ' ' . $this -> getAddress -> city ;
        return [
            'id' =>$this ->id,
            'name' =>$this ->name,
            'price' =>$this ->price,
            'discount' =>$this ->discount,
            'star' =>$this ->star,
            'description' =>$this ->description,
            'image_rooms' =>$room_images,
            'hotel_images' =>$hotel_images,
            'address' =>$address
        ];
    }

    public function toOneArray(Request $request): array
    {
        $room_images = is_array($this->room_images) ? $this->room_images : [$this->room_images];
        $hotel_images = is_array($this->hotel_images) ? $this->hotel_images : [$this->hotel_images];
        $offers = is_array($this->offers) ? $this->offers : [$this->offers];
        $address =$this -> getAddress -> country . ' ' . $this -> getAddress -> province . ' ' . $this -> getAddress -> city ;
        return [
            'id' =>$this ->id,
            'name' =>$this ->name,
            'price' =>$this ->price,
            'discount' =>$this ->discount,
            'star' =>$this ->star,
            'description' =>$this ->description,
            'policy' =>$this ->policy,
            'rule' =>$this ->rule,
            'image_rooms' =>$room_images,
            'hotel_images' =>$hotel_images,
            'offers' =>$offers,
            'address' =>$address
        ];
    }
}
