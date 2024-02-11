<?php

namespace App\Models\Address;

use App\Models\Stay\Stay;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = "address";
    protected $guarded = ["id"];

    public function getAllStay()
    {
        return $this->hasMany(Stay::class, 'address_id');
    }
    public function stay()
    {
        return $this->hasMany(Stay::class);
    }
}
