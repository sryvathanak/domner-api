<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'stay_name' => optional($this->getStay)->name,
            'bus_name' => optional($this->getBus)->name,
            'bus_logo' => optional($this->getBus)->logo,
            'flight_name' => optional($this->getFlight)->name,
            'flight_logo' => optional($this->getFlight)->logo,
            'train_name' => optional($this->getTrain)->name,
            'train_logo' => optional($this->getTrain)->logo,
            'tour_company_name' => optional($this->getTour)->company_name,
            'tour_logo' => optional($this->getTour)->logo,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'total_price' => $this->total_price,
            'day' => $this->day,
            'member' => $this->member,
        ];
    }
}
