<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;
    protected $table ="flights";
    protected $guarded = ["id"];

    protected $fillable = [
        'client_id',
        'name',
        'price',
        'discount',
        'from_date',
        'to_date',
        'time',
        'flight_images',
        'includes',
        'code_from',
        'from',
        'to',
        'airplane_name',
        'punctuality',
        'airport_from',
        'airport_to',
        'code_to',
        'logo',
        'star',
        'is_deleted',
        'description',
        'info_flight',
        // Add other attributes as needed
    ];

    protected $casts = [
        'flight_images' => 'json',
        "includes" =>"json",
    ];
}
