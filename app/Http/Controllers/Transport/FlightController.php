<?php

namespace App\Http\Controllers\Transport;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Transport\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function create(Request $request)
    {
        $path_flight = 'C:/Users/User/Documents/domner-app/domner/src/storage/upload/images/';
        $request->validate([

            'name' => 'required',
            'price' => 'required|numeric',
            'time' => 'required|numeric',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'flight_images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->has('flight_images')) {
            $image = $request->flight_images;
            foreach ($image as $key => $value) {
                $name = time() . $key . '.' . $value->getClientOriginalExtension();

                //$path = storage_path('app/flights/upload');

                $value->move($path_flight, $name);
                $uploadedImages[] = $name;
            }
        }
        if ($request->has('logo')) {
            $logo = $request->logo;
            $name_logo = time() . '.' . $logo->getClientOriginalExtension();
            //$path_logo = storage_path('app/flights/upload');
            $logo->move($path_flight, $name_logo);
        }

        $flight = Flight::create([
            'client_id' => auth()->check() ? auth()->user()->id : null,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'discount' => $request->input('discount', 0),
            'from_date' => $request->input('from_date'),
            'to_date' => $request->input('to_date'),
            'time' => $request->input('time'),
            'flight_images' => $uploadedImages,
            'includes' => $request->input('includes'),
            'code_from' => $request->input('code_from'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'airplane_name' => $request->input('airplane_name'),
            'punctuality' => $request->input('punctuality', 0),
            'airport_from' => $request->input('airport_from'),
            'airport_to' => $request->input('airport_to'),
            'code_to' => $request->input('code_to'),
            'logo' => $name_logo,
            'star' => $request->input('star'),
            'description' => $request->input('description'),
            'info_flight' => $request->input('info_flight'),
            // Add other fields here
        ]);
        return response()->json([
            "message" => "Create Successfully !",
            "success"  => true,
            "flight" => $flight
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $path_flight = 'C:/Users/User/Documents/domner-app/domner/src/storage/upload/images/';
        $uploadedImages = [];
        $name_logo = '';
        if ($request->has('flight_images')) {
            $image = $request->flight_images;
            foreach ($image as $key => $value) {
                $name = time() . $key . '.' . $value->getClientOriginalExtension();
                //$path = storage_path('app/flights/upload');
                $value->move($path_flight, $name);
                $uploadedImages[] = $name;
            }
        }

        if ($request->has('logo')) {
            $logo = $request->logo;
            $name_logo = time() . '.' . $logo->getClientOriginalExtension();
            $path_logo = storage_path('app/flights/upload');
            $logo->move($path_flight, $name_logo);
        }
        $client_id = auth()->check() ? auth()->user()->id : null;
        $flight = Flight::findOrFail($id);
        if ($flight->client_id !== $client_id) {
            return response()->json([
                'message' => 'Unauthorized: You do not have permission to delete this record.',
                'status' => false,
            ], 403);
        }
        if ($flight) {
            $flight->update([
                'client_id' => auth()->check() ? auth()->user()->id : null,
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'discount' => $request->input('discount', 0),
                'from_date' => $request->input('from_date'),
                'to_date' => $request->input('to_date'),
                'time' => $request->input('time'),
                'flight_images' => $uploadedImages,
                'includes' => $request->input('includes'),
                'code_from' => $request->input('code_from'),
                'from' => $request->input('from'),
                'to' => $request->input('to'),
                'airplane_name' => $request->input('airplane_name'),
                'punctuality' => $request->input('punctuality', 0),
                'airport_from' => $request->input('airport_from'),
                'airport_to' => $request->input('airport_to'),
                'code_to' => $request->input('code_to'),
                'logo' => $name_logo,
                'star' => $request->input('star'),
                'description' => $request->input('description'),
                'info_flight' => $request->input('info_flight'),
            ]);

            $updated = Flight::find($id);

            return response()->json(
                [
                    'message' => 'Update Succesfully',
                    'status' => true,
                    'data' => $updated
                ]
            );
        }
        return response()->json(['message' => 'Flight id not found', 'status' => false, 400]);
    }

    public function get()
    {
        $client_id = auth()->check() ? auth()->user()->id : null;
        $flight = Flight::where('client_id', $client_id)->get();
        $count = $flight->count();
        return response()->json([
            'status' => true,
            'message' => 'Flight data retrieved successfully',
            'total_record' => $count,
            'data' => $flight,
        ], 200);
    }

    public function delete($id)
    {
        $client_id = auth()->check() ? auth()->user()->id : null;
        $flight = Flight::find($id);

        if ($flight->client_id !== $client_id) {
            return response()->json([
                'message' => 'Unauthorized: You do not have permission to delete this record.',
                'status' => false,
            ], 403);
        }

        if ($flight) {
            $flight->delete();
            return response()->json(
                [
                    'message' => 'Delete Has Success',
                    'status' => true,
                ],
                200
            );
        }


        return response()->json(
            [
                'message' => 'Not Found',
                'status' => false,
            ],
            400
        );
    }
}
