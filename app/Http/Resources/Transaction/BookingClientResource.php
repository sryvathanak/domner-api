<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'stay_price' => optional($this->getStay)->price,
            'bed' => optional($this->getStay)->bed,
            'bus_price' => optional($this->getBus)->price,
            'flight_price' => optional($this->getFlight)->price,
            'train_price' => optional($this->getTrain)->price,
            'tour_price' => optional($this->getTour)->price,
            'payment' => $this->getPayment,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'total_price' => $this->total_price,
            'day' => $this->day,
            'member' => $this->member,
            'children' => $this->children,
            'age' => $this->age,
            'star' => $this->star,
            'description' => $this->description,
            'comment' => $this->comment,
            'booking_by' => $this->getUser->username,
            'booking_date' => $this->created_at,
            'email' => $this->getUser->email,
            'phone_number' => $this->getUser->phone_number,
        ];
    }
}
