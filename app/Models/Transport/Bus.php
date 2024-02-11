<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;
    protected $table ="buss";
    protected $guarded = ["id"];

    protected $fillable = [
        'client_id',
        'name',
        'price',
        'discount',
        'from_date',
        'to_date',
        'time',
        'bus_images',
        'includes',
        'code_from',
        'from',
        'to',
        'code_to',
        'logo',
        'star',
        'is_deleted',
        'description',
    ];

    protected $casts = [
        'bus_images' => 'json',
        "includes" =>"json",
    ];
}
