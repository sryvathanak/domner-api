<?php

namespace App\Http\Controllers\Tour;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tour\TourResource;
use App\Models\Tour\ArrangeTour;
use Illuminate\Http\Request;

class TourControllerInfo extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tour = ArrangeTour::all();
        $count = $tour ->count();
        return response()->json([
            'status' => true,
            'message' => 'Tour data retrieved successfully',
            'total_record' => $count,
            'data' => TourResource::collection($tour),
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tour = ArrangeTour::find($id);
        $formattedData = (new TourResource($tour))->toOneArray(request());
        return response()->json([
            'status' => true,
            'message' => 'Tour data retrieved successfully',
            'data' => $formattedData,
        ], 200);
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
