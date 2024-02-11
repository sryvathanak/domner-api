<?php

namespace App\Models\Stay;

use App\Models\Address\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stay extends Model
{
    use HasFactory;
    protected $table = "stays";
    protected $guarded = ["id"];

    protected $fillable = ['client_id', 'address_id', 'name', 'bed', 'price', 'discount', 'hotel_images', 'room_images', 'offers', 'star', 'description', 'policy', 'role'];

    protected $casts = [
        "room_images" => "json",
        "hotel_images" => "json",
        "offers" => "json",
    ];

    public function getAddress()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
