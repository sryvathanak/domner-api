<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Resources\Address\AddressResorce;
use App\Models\Address\Address;
use Illuminate\Http\Request;

class AddressControlller extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            "country" => "required",
        ]);

        $address = Address::create($request->all());

        return response()->json([
            "message" => "Create Successfully !",
            "success"  => true,
            "stay" => $address
        ]);
    }

    public function list_stay(Request $request)
    {
        $query = Address::query();
        $keyword = $request->keyword;
        if ($keyword === null || trim($keyword) === '') {
            // If keyword is null, empty, or undefined, return an empty response
            return response()->json([
                'status' => true,
                'message' => 'Stay data retrieved successfully',
                'total_record' => 0,
                'data' => [],
            ], 200);
        }

        $query->where(function ($q) use ($keyword) {
            $q->where('country', 'LIKE', "%$keyword%")
                ->orWhere('province', 'LIKE', "%$keyword%")
                ->orWhere('city', 'LIKE', "%$keyword%")
                ->orWhereHas('stay', function ($innerQ) use ($keyword) {
                    $innerQ->where('name', 'LIKE', "%$keyword%");
                });
        });


        $addresss = $query->get();
        $count = $addresss->count();
        return response()->json([
            'status' => true,
            'message' => 'Stay data retrieved successfully',
            'total_record' => $count,
            'data' => AddressResorce::collection($addresss),

        ], 200);
    }


    public function address(Request $request)
    {
        $searchTerm = $request->input('keyword');
        $address = [];
        if ($searchTerm == '') {
            return response()->json([
                "message" => "Get All Successfully",
                "status" => true,
                "data" => []
            ]);
        }
        if ($searchTerm) {
            // Query addresses based on the search term
            $address = Address::where('city', 'like', '%' . $searchTerm . '%')
                ->orWhere('province', 'like', '%' . $searchTerm . '%')
                ->orWhere('district', 'like', '%' . $searchTerm . '%')
                ->orWhere('commune', 'like', '%' . $searchTerm . '%')
                ->orWhere('village', 'like', '%' . $searchTerm . '%')->get();
        }

        // Return the addresses as a response, you can customize this as needed
        return response()->json([
            "message" => "Get All Successfully",
            "status" => true,
            "data" => $address
        ]);
    }
}
