<?php

namespace App\Models\MyFavorite;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $table ="my_favorites";
    protected $guarded = ["id"];

    protected $fillable=["user_id","trip_id","stay_id","like"];

    
}
