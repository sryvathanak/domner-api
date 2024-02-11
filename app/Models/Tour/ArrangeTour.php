<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrangeTour extends Model
{
    use HasFactory;
    protected $table ="arrange_tours";
    protected $guarded = ["id"];

    protected $fillable = [
        'client_id',
        'company_name',
        'price',
        'discount',
        'from_date',
        'to_date',
        'day',
        'trip_images',
        'trip_videos',
        'includes',
        'places',
        'member',
        'logo',
        'star',
        'is_deleted',
        'description',
        'about_tour',
        // Add other fields here
    ];

    protected $casts = [
        'places' => 'json',
        "includes" =>"json",
        "trip_images" =>"json",
        "trip_videos" => "json",
    ];
}
