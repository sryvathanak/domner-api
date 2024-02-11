<?php

namespace App\Http\Controllers\Transport;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transport\BusResource;
use App\Models\Transport\Bus;
use Illuminate\Http\Request;

class BusControllerInfo extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Bus::query();
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
                $q->where('code_from', 'LIKE', "%$from%")
                    ->orWhere('from', 'LIKE', "%$from%");
            });
        }

        if ($to) {
            $query->where(function ($q) use ($to) {
                $q->where('code_to', 'LIKE', "%$to%")
                    ->orWhere('to', 'LIKE', "%$to%");
            });
        }
        $buss = $query->get();
        $count = $buss->count();
        return response()->json([
            'status' => true,
            'message' => 'Bus data retrieved successfully',
            'total_record' => $count,
            'data' => BusResource::collection($buss),
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
        $bus = Bus::find($id);
        $formattedData = (new BusResource($bus))->toOneArray(request());

        return response()->json([
            'status' => true,
            'message' => 'Bus data retrieved successfully',
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
