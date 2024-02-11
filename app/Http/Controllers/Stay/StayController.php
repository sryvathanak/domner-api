<?php

namespace App\Http\Controllers\Stay;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\Stay\StayResource;
use App\Models\Stay\Stay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StayController extends Controller
{
    public function create(Request $request)
    {
        $path_stay = 'C:/Users/User/Documents/domner-app/domner/src/storage/upload/images/';
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'address_id' => 'required',
            //'hotel_images' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            //'room_images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        //Log::info("client_id: ");
        //
        // if ($request->has('room_images')) {
        //     $uploadedImages = [];
        //     $image = $request->room_images;
        //     foreach ($image as $key => $value) {
        //         $name = time() . $key . '.' . $value->getClientOriginalExtension();

        //         //  $path = storage_path('app/stays/upload');
        //         //$path = 'C:/Users/User/Documents/domner-app/domner/src/storage/upload/images';
        //         $value->move($path_stay, $name);
        //         $uploadedImages[] = $name;
        //     }
        // }

        // if ($request->has('hotel_images')) {

        //     $image = $request->hotel_images;
        //     foreach ($image as $key => $value) {
        //         $name_image = time() . $key . '.' . $value->getClientOriginalExtension();

        //         // $path_image = storage_path('app/stays/upload');

        //         $value->move($path_stay, $name_image);
        //         $hotelImages[] = $name_image;
        //     }
        // }
        $stay = Stay::create([
            "client_id" => auth()->check() ? auth()->user()->id : null,
            "address_id" => $request->address_id,
            "name" => $request->name,
            "bed" => $request->bed,
            "price" => $request->price,
            "discount" => $request->input('discount', 0),
            "hotel_images" => $request->hotel_images,
            "room_images" => $request->room_images,
            "offers" => $request->offers,
            "star" => $request->star,
            "description" => $request->description,
            "policy" => $request->policy,
            "role" => $request->role,
        ]);

        return response()->json([
            "message" => "Create Successfully !",
            "status"  => true,
            "stay" => $stay
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $path_stay = 'C:/Users/User/Documents/domner-app/domner/src/storage/upload/images/';
        $uploadedImages = [];
        if ($request->has('room_images')) {
            $uploadedImages = [];
            $image = $request->room_images;
            foreach ($image as $key => $value) {
                $name = time() . $key . '.' . $value->getClientOriginalExtension();

                //$path = storage_path('app/stays/upload');
                //$path = 'C:/Users/User/Documents/domner-app/domner/src/storage/upload';
                $value->move($path_stay, $name);
                $uploadedImages[] = $name;
            }
        }
        $hotelImages = [];
        if ($request->has('hotel_images')) {

            $image = $request->hotel_images;
            foreach ($image as $key => $value) {
                $name_image = time() . $key . '.' . $value->getClientOriginalExtension();

                // $path_image = storage_path('app/stays/upload');

                $value->move($path_stay, $name_image);
                $hotelImages[] = $name_image;
            }
        }

        $stay = Stay::findOrFail($id);
        $client_id = auth()->check() ? auth()->user()->id : null;
        if ($stay->client_id !== $client_id) {
            return response()->json([
                'message' => 'Unauthorized: You do not have permission to delete this record.',
                'status' => false,
            ], 403);
        }
        if ($stay) {
            $stay->update([
                "client_id" => auth()->check() ? auth()->user()->id : null,
                "address_id" => $request->address_id,
                "name" => $request->name,
                "bed" => $request->bed,
                "price" => $request->price,
                "discount" => $request->input('discount', 0),
                "hotel_images" => $hotelImages,
                "room_images" => $uploadedImages,
                "offers" => $request->offers,
                "star" => $request->star,
                "description" => $request->description,
                "policy" => $request->policy,
                "role" => $request->role,
            ]);
            $updated = Stay::find($id);

            return response()->json(
                [
                    'message' => 'Update Succesfully',
                    'status' => true,
                    'data' => $updated
                ]
            );
        }

        return response()->json(['message' => 'Stay id not found', 'status' => false, 400]);
    }

    public function get()
    {
        $client_id = auth()->check() ? auth()->user()->id : null;
        $stay = Stay::where('client_id', $client_id)->get();
        $count = $stay->count();
        return response()->json([
            'status' => true,
            'message' => 'Stay data retrieved successfully',
            'total_record' => $count,
            'data' => $stay,
        ], 200);
    }

    public function delete($id)
    {
        $client_id = auth()->check() ? auth()->user()->id : null;
        $stay = Stay::find($id);

        if ($stay->client_id !== $client_id) {
            return response()->json([
                'message' => 'Unauthorized: You do not have permission to delete this record.',
                'status' => false,
            ], 403);
        }

        if ($stay) {
            $stay->delete();
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
