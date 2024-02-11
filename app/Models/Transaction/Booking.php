<?php

namespace App\Models\Transaction;

use App\Models\Stay\Stay;
use App\Models\Tour\ArrangeTour;
use App\Models\Transport\Bus;
use App\Models\Transport\Flight;
use App\Models\Transport\Train;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = "books";
    protected $guarded = ["id"];

    protected $casts = [
        "age" => "json",
    ];

    public function getStay()
    {
        return $this->belongsTo(Stay::class, 'stay_id');
    }
    public function getTour()
    {
        return $this->belongsTo(ArrangeTour::class, 'trip_id');
    }
    public function getFlight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }

    public function getBus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }

    public function getTrain()
    {
        return $this->belongsTo(Train::class, 'train_id');
    }

    public function getPayment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
