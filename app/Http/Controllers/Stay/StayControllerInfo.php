<?php

namespace App\Http\Controllers\Stay;

use App\Http\Controllers\Controller;
use App\Http\Resources\Stay\StayResource;
use App\Models\Stay\Stay;
use Illuminate\Http\Request;

class StayControllerInfo extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Stay::query();
        $keyword = $request->keyword;

        if ($keyword) {
            $query->whereHas('address', function ($q) use ($keyword) {
                $q->where('city', 'LIKE', "%$keyword%");
            });
        }

        $stays = $query->get();
        $count = $stays->count();
        return response()->json([
            'status' => true,
            'message' => 'Stay data retrieved successfully',
            'total_record' => $count,
            'data' => StayResource::collection($stays),

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
    public function show($id)
    {
        $stay = Stay::find($id);
        $formattedData = (new StayResource($stay))->toOneArray(request());
        return response()->json([
            'status' => true,
            'message' => 'Stay data retrieved successfully',
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
