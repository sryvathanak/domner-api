<?php

namespace App\Http\Controllers\MyFavorite;

use App\Http\Controllers\Controller;
use App\Http\Resources\MyFavorite\FavoriteResource;
use App\Http\Resources\Stay\StayResource;
use App\Http\Resources\Tour\TourResource;
use App\Models\MyFavorite\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->check() ? auth()->user()->id : null;
        $user = User::find($user_id);
        $favorite_tour = $user->getAllTour;
        $favorite_stay = $user->getAllStay;

        $count_tour = $favorite_tour->count();
        $count_stay = $favorite_stay->count();


        $favorite_tour = TourResource::collection($favorite_tour);

        $favorite_stay = StayResource::collection($favorite_stay);


        //$tour = TourResource::collection($favorite_tour);
        return response()->json(
            [
                "message" => "Get Successfully",
                "status" => "true",
                "total_tour_record" => $count_tour,
                "total_stay_record" => $count_stay,
                "tour" => $favorite_tour,
                "stay" => $favorite_stay
            ],
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth()->check() ? auth()->user()->id : null;


        if ($request->trip_id) {
            $tour_liked = Favorite::where("trip_id", $request->trip_id)->where("user_id", $user_id)->first();
            if ($tour_liked) {

                $tour_liked->delete();
                return response()->json([
                    "message" => "UnLiked",
                    "status" => true
                ], 200);
            }
        }
        if ($request->stay_id) {
            $stay_liked = Favorite::where("stay_id", $request->stay_id)->where("user_id", $user_id)->first();

            if ($stay_liked) {

                $stay_liked->delete();
                return response()->json([
                    "message" => "UnLiked",
                    "status" => true
                ], 200);
            }
        }

        Favorite::create([
            "trip_id" => $request->trip_id,
            "user_id" => $user_id,
            "stay_id" => $request->stay_id,
            "like" => true
        ]);
        return response()->json([
            "message" => "Liked",
            "status" => true
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
