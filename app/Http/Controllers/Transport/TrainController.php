<?php

namespace App\Http\Controllers\Transport;

use App\Http\Controllers\Controller;
use App\Models\Transport\Train;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrainController extends Controller
{
    public function create(Request $request)
    {
        $path_train = 'C:/Users/User/Documents/domner-app/domner/src/storage/upload/images/';
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'time' => 'required|numeric',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'train_images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->has('train_images')) {
            $image = $request->train_images;
            foreach ($image as $key => $value) {
                $name = time() . $key . '.' . $value->getClientOriginalExtension();

                //$path = storage_path('app/trains/upload');

                $value->move($path_train, $name);
                $uploadedImages[] = $name;
            }
        }

        if ($request->has('logo')) {
            $logo = $request->logo;
            $name_logo = time() . '.' . $logo->getClientOriginalExtension();
            // $path_logo = storage_path('app/trains/upload');
            $logo->move($path_train, $name_logo);
        }


        $train = Train::create([
            'client_id' => auth()->check() ? auth()->user()->id : null,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'discount' => $request->input('discount', 0),
            'from_date' => $request->input('from_date'),
            'to_date' => $request->input('to_date'),
            'time' => $request->input('time'),
            'train_images' => $uploadedImages,
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
            'data' => $train,
            'message' => 'Train created successfully',
            'status' => true,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $path_train = 'C:/Users/User/Documents/domner-app/domner/src/storage/upload/images/';
        $uploadedImages = [];
        $name_logo = '';
        if ($request->has('train_images')) {
            $image = $request->train_images;
            foreach ($image as $key => $value) {
                $name = time() . $key . '.' . $value->getClientOriginalExtension();
                //$path = storage_path('app/trains/upload');
                $value->move($path_train, $name);
                $uploadedImages[] = $name;
            }
        }

        if ($request->has('logo')) {
            $logo = $request->logo;
            $name_logo = time() . '.' . $logo->getClientOriginalExtension();
            // $path_logo = storage_path('app/trains/upload');
            $logo->move($path_train, $name_logo);
        }
        $client_id = auth()->check() ? auth()->user()->id : null;
        $train = Train::findOrFail($id);
        if ($train->client_id !== $client_id) {
            return response()->json([
                'message' => 'Unauthorized: You do not have permission to delete this record.',
                'status' => false,
            ], 403);
        }
        if ($train) {
            $train->update([
                'client_id' => auth()->check() ? auth()->user()->id : null,
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'discount' => $request->input('discount', 0),
                'from_date' => $request->input('from_date'),
                'to_date' => $request->input('to_date'),
                'time' => $request->input('time'),
                'train_images' => $uploadedImages,
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

            $updated = Train::find($id);

            return response()->json(
                [
                    'message' => 'Update Succesfully',
                    'status' => true,
                    'data' => $updated
                ]
            );
        }
        return response()->json(['message' => 'Train id not found', 'status' => false, 400]);
    }

    public function get()
    {
        $client_id = auth()->check() ? auth()->user()->id : null;
        $train = Train::where('client_id', $client_id)->get();
        $count = $train->count();
        return response()->json([
            'status' => true,
            'message' => 'Train data retrieved successfully',
            'total_record' => $count,
            'data' => $train,
        ], 200);
    }

    public function delete($id)
    {
        $client_id = auth()->check() ? auth()->user()->id : null;
        $train = Train::find($id);

        if ($train->client_id !== $client_id) {
            return response()->json([
                'message' => 'Unauthorized: You do not have permission to delete this record.',
                'status' => false,
            ], 403);
        }
        if ($train) {
            $train->delete();
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
