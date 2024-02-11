<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    use HasFactory;
    protected $table ="trains";
    protected $guarded = ["id"];

    protected $fillable = [
        'client_id',
        'name',
        'price',
        'discount',
        'from_date',
        'to_date',
        'time',
        'train_images',
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
        'train_images' => 'json',
        "includes" =>"json",
    ];
}
