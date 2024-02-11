<?php

namespace App\Http\Resources\Transport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $includes = is_array($this->includes) ? $this->includes : [$this->includes];
        $from_time = $this->from_date;
        $carbonFromTime = \Carbon\Carbon::parse($from_time);
        $formattedFromTime = $carbonFromTime->format('g:i A');
        $to_time = $this->to_date;
        $carbonToTime = \Carbon\Carbon::parse($to_time);
        $formattedToTime = $carbonToTime->format('g:i A');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'discount' => $this->discount,
            'star' => $this->star,
            'time' => $this->time,
            'from' => $this->from,
            'to' => $this->to,
            'from_time' => $formattedFromTime,
            'to_time' => $formattedToTime,
            'code_from' => $this->code_from,
            'code_to' => $this->code_to,
            'airplane_name' => $this->airplane_name,
            'punctuality' => $this->punctuality,
            'includes' => $includes,
            'logo' => $this->logo,

        ];
    }

    public function toOneArray(Request $request): array
    {
        $includes = is_array($this->includes) ? $this->includes : [$this->includes];
        $flight_images = is_array($this->flight_images) ? $this->flight_images : [$this->flight_images];
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'discount' => $this->discount,
            'star' => $this->star,
            'time' => $this->time,
            'from' => $this->from,
            'to' => $this->to,
            'code_from' => $this->code_from,
            'code_to' => $this->code_to,
            'airplane_name' => $this->airplane_name,
            'punctuality' => $this->punctuality,
            'includes' => $includes,
            'flight_images' => $flight_images,
            'logo' => $this->logo,
            'airport_from' => $this->airport_from,
            'airport_to' => $this->airport_to,
            'description' => $this->description,
            'info_flight' => $this->info_flight,


        ];
    }
}
