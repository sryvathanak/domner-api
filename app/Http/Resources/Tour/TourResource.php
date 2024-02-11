<?php

namespace App\Http\Resources\Tour;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
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

        $startTime = Carbon::parse($this->created_at);
        $endTime = Carbon::now(); // Assuming the next day for illustration
        $post_time = null;
        $secondsDifference = $endTime->diffInSeconds($startTime);


        $days = $endTime->diffInDays($startTime);
        $hours = $endTime->diffInHours($startTime);
        $minutes = $endTime->diffInMinutes($startTime);

        if ($secondsDifference < 60) {
            $post_time = strval($secondsDifference) . 's ago';
        } else if ($minutes < 60 && $minutes > 0) {
            $post_time = strval($minutes) . 'm ago';
        } else if ($hours > 0 && $hours < 24) {
            $post_time = strval($hours) . 'h ago';
        } else if ($days > 0) {
            $post_time = strval($days) . 'day ago';
        }


        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'price' => $this->price,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'discount' => $this->discount,
            'star' => $this->star,
            'day' => $this->day,
            'logo' => $this->logo,
            'member' => $this->member,
            'includes' => $includes,
            'description' => $this->description,
            'places' => $places,
            'profile_tour' => $this->profile,
            'post_time' => $post_time,
            'create_date' => $this->created_at
        ];
    }

    public function toOneArray(Request $request): array
    {
        $places = is_array($this->places) ? $this->places : [$this->places];
        $includes = is_array($this->includes) ? $this->includes : [$this->includes];
        $trip_images = is_array($this->trip_images) ? $this->trip_images : [$this->trip_images];
        $trip_videos = is_array($this->trip_videos) ? $this->trip_videos : [$this->trip_videos];
        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'price' => $this->price,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'discount' => $this->discount,
            'star' => $this->star,
            'day' => $this->day,
            'logo' => $this->logo,
            'member' => $this->member,
            'includes' => $includes,
            'trip_images' => $trip_images,
            'trip_videos' => $trip_videos,
            'description' => $this->description,
            'about_tour' => $this->about_tour,
            'places' => $places,
        ];
    }
}
