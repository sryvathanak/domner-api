<?php

namespace App\Http\Resources\MyFavorite;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $places = is_array($this->places) ? $this->places : [$this->places];
        $includes = is_array($this->includes) ? $this->includes : [$this->includes];
        return [
            'id' =>$this ->id,
            'company_name' =>$this ->company_name,
            'price' =>$this ->price,
            'from_date' =>$this ->from_date,
            'to_date' =>$this ->to_date,
            'discount' =>$this ->discount,
            'star' =>$this ->star,
            'day' =>$this ->day,
            'logo' =>$this ->logo,
            'member' =>$this ->member,
            'includes' =>$includes,
            'description' =>$this ->description,
            'places' =>$places,
        ];
    }

    public function toStayArray(Request $request): array
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
}
