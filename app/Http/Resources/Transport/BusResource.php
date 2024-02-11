<?php

namespace App\Http\Resources\Transport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusResource extends JsonResource
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

        $duration = $carbonFromTime->diff($carbonToTime);

        // Format the duration into hours:minutes:seconds format
        $formattedDuration = sprintf('%dh:%02dm', $duration->h, $duration->i);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'discount' => $this->discount,
            'star' => $this->star,
            'time' => $formattedDuration,
            'from' => $this->from,
            'to' => $this->to,
            'from_time' => $formattedFromTime,
            'to_time' => $formattedToTime,
            'code_from' => $this->code_from,
            'code_to' => $this->code_to,
            'includes' => $includes,
            'logo' => $this->logo,

        ];
    }

    public function toOneArray(Request $request): array
    {
        $includes = is_array($this->includes) ? $this->includes : [$this->includes];
        $bus_images = is_array($this->bus_images) ? $this->bus_images : [$this->bus_images];
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
            'includes' => $includes,
            'bus_images' => $bus_images,
            'logo' => $this->logo,
            'description' => $this->description,

        ];
    }
}
