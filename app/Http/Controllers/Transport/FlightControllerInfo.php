<?php

namespace App\Http\Controllers\Transport;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transport\FlightResource;
use App\Models\Transport\Flight;
use Illuminate\Http\Request;

class FlightControllerInfo extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Flight::query();
        $from = $request->from;
        $to = $request->to;



        if ($from == '' && $to == '') {
            return response()->json([
                'status' => true,
                'message' => 'Flight data retrieved successfully',
                'total_record' => 0,
                'data' => [],
            ], 200);
        }

        if ($from) {
            $query->where(function ($q) use ($from) {
                $q->where('from', 'LIKE', "%$from%")
                    ->orWhere('airport_from', 'LIKE', "%$from%");
            });
        }

        if ($to) {
            $query->where(function ($q) use ($to) {
                $q->where('to', 'LIKE', "%$to%")
                    ->orWhere('airport_to', 'LIKE', "%$to%");
            });
        }
        $flights = $query->get();
        $count = $flights->count();
        return response()->json([
            'status' => true,
            'message' => 'Flight data retrieved successfully',
            'total_record' => $count,
            'data' => FlightResource::collection($flights),
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
        $flight = Flight::find($id);
        $formattedData = (new FlightResource($flight))->toOneArray(request());
        return response()->json([
            'status' => true,
            'message' => 'Flight data retrieved successfully',
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
