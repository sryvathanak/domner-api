<?php

namespace App\Http\Controllers\Transport;

use App\Http\Controllers\Controller;
use App\Models\Transport\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function create(Request $request)
    {
        $path_bus = 'C:/Users/User/Documents/domner-app/domner/src/storage/upload/images/';
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'time' => 'required|numeric',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bus_images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->has('bus_images')) {
            $image = $request->bus_images;
            foreach ($image as $key => $value) {
                $name = time() . $key . '.' . $value->getClientOriginalExtension();

                // $path = storage_path('app/buss/upload');

                $value->move($path_bus, $name);
                $uploadedImages[] = $name;
            }
        }

        if ($request->has('logo')) {
            $logo = $request->logo;
            $name_logo = time() . '.' . $logo->getClientOriginalExtension();
            // $path_logo = storage_path('app/buss/upload');
            $logo->move($path_bus, $name_logo);
        }
        $bus = Bus::create([
            'client_id' => auth()->check() ? auth()->user()->id : null,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'discount' => $request->input('discount', 0),
            'from_date' => $request->input('from_date'),
            'to_date' => $request->input('to_date'),
            'time' => $request->input('time'),
            'bus_images' => $uploadedImages,
            'includes' => $request->input('includes'),
            'code_from' => $request->input('code_from'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'logo' => $name_logo,
            'star' => $request->input('star'),
            'is_deleted' => $request->input('is_deleted', false),
            'description' => $request->input('description'),
        ]);
        return response()->json([
            'data' => $bus,
            'message' => 'Bus created successfully',
            'status' => true,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $path_bus = 'C:/Users/User/Documents/domner-app/domner/src/storage/upload/images/';
        $uploadedImages = [];
        $name_logo = '';
        if ($request->has('bus_images')) {
            $image = $request->bus_images;
            foreach ($image as $key => $value) {
                $name = time() . $key . '.' . $value->getClientOriginalExtension();
                // $path = storage_path('app/buss/upload');
                $value->move($path_bus, $name);
                $uploadedImages[] = $name;
            }
        }

        if ($request->has('logo')) {
            $logo = $request->logo;
            $name_logo = time() . '.' . $logo->getClientOriginalExtension();
            //  $path_logo = storage_path('app/buss/upload');
            $logo->move($path_bus, $name_logo);
        }
        $bus = Bus::findOrFail($id);
        $client_id = auth()->check() ? auth()->user()->id : null;
        if ($bus->client_id !== $client_id) {
            return response()->json([
                'message' => 'Unauthorized: You do not have permission to delete this record.',
                'status' => false,
            ], 403);
        }
        if ($bus) {
            $bus->update([
                'client_id' => auth()->check() ? auth()->user()->id : null,
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'discount' => $request->input('discount', 0),
                'from_date' => $request->input('from_date'),
                'to_date' => $request->input('to_date'),
                'time' => $request->input('time'),
                'bus_images' => $uploadedImages,
                'includes' => $request->input('includes'),
                'code_from' => $request->input('code_from'),
                'code_to' => $request->input('code_to'),
                'from' => $request->input('from'),
                'to' => $request->input('to'),
                'logo' => $name_logo,
                'star' => $request->input('star'),
                'is_deleted' => $request->input('is_deleted', false),
                'description' => $request->input('description'),
            ]);

            $updated = Bus::find($id);

            return response()->json(
                [
                    'message' => 'Update Succesfully',
                    'status' => true,
                    'data' => $updated
                ]
            );
        }
        return response()->json(['message' => 'Bus id not found', 'status' => false, 400]);
    }

    public function get()
    {
        $client_id = auth()->check() ? auth()->user()->id : null;
        $bus = Bus::where('client_id', $client_id)->get();
        $count = $bus->count();
        return response()->json([
            'status' => true,
            'message' => 'Bus data retrieved successfully',
            'total_record' => $count,
            'data' => $bus,
        ], 200);
    }

    public function delete($id)
    {
        $client_id = auth()->check() ? auth()->user()->id : null;
        $bus = Bus::find($id);

        if ($bus->client_id !== $client_id) {
            return response()->json([
                'message' => 'Unauthorized: You do not have permission to delete this record.',
                'status' => false,
            ], 403);
        }

        if ($bus) {
            $bus->delete();
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
