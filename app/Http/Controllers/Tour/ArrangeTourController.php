<?php

namespace App\Http\Controllers\Tour;

use App\Http\Controllers\Controller;
use App\Models\Tour\ArrangeTour;
use Illuminate\Http\Request;

class ArrangeTourController extends Controller
{
    public function create(Request $request)
    {
        $path_tour = 'C:/Users/User/Documents/domner-app/domner/src/screen/assets/images/';
        $path_tour_video = 'C:/Users/User/Documents/domner-app/domner/src/screen/assets/videos/';
        $request->validate([

            'company_name' => 'required',
            'day' => 'required',
            'price' => 'required|numeric',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trip_images' => 'required',
            'trip_images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trip_videos.*' => 'required|file|mimes:mp4,mov,avi,wmv|max:20480',
        ]);
        $uploadedImages = [];
        if ($request->has('trip_images')) {
            $image = $request->trip_images;
            foreach ($image as $key => $value) {
                $name = time() . $key . '.' . $value->getClientOriginalExtension();
                //   $path = storage_path('app/tours/upload');

                $value->move($path_tour, $name);
                $uploadedImages[] = $name;
            }
        }
        if ($request->has('logo')) {
            $logo = $request->logo;
            $name_logo = time() . '.' . $logo->getClientOriginalExtension();
            //  $path_logo = storage_path('app/tours/upload');
            $logo->move($path_tour, $name_logo);
        }

        $uploadedVideos = [];

        if ($request->has('trip_videos')) {
            $videos = $request->file('trip_videos');

            foreach ($videos as $key => $video) {
                $name_video = time() . $key . '.' . $video->getClientOriginalExtension();
                // $path_video = storage_path('app/tours/upload/videos');
                $video->move($path_tour_video, $name_video);
                $uploadedVideos[] = $name_video;
            }
        }


        $tour = ArrangeTour::create([
            'client_id' => auth()->check() ? auth()->user()->id : null,
            'company_name' => $request->input('company_name'),
            'price' => $request->input('price'),
            'discount' => $request->input('discount', 0),
            'from_date' => $request->input('from_date'),
            'to_date' => $request->input('to_date'),
            'day' => $request->input('day'),
            'trip_images' => $uploadedImages, // You need to define $uploadedImages
            'trip_videos' => $uploadedVideos, // Assuming 'trip_videos' is an array in the request
            'includes' => $request->input('includes'),
            'places' => $request->input('places'),
            'member' => $request->input('member'),
            'logo' =>  $name_logo, // You need to define $name_logo
            'star' => $request->input('star'),
            'is_deleted' => $request->input('is_deleted', false),
            'description' => $request->input('description'),
            'about_tour' => $request->input('about_tour'),

        ]);

        return response()->json([
            'data' => $tour,
            'message' => 'Tour created successfully',
            'status' => true,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $uploadedImages = [];
        $name_logo = '';
        $uploadedVideos = [];
        if ($request->has('trip_images')) {
            $image = $request->trip_images;
            foreach ($image as $key => $value) {
                $name = time() . $key . '.' . $value->getClientOriginalExtension();
                $path = storage_path('app/tours/upload');

                $value->move($path, $name);
                $uploadedImages[] = $name;
            }
        }
        if ($request->has('logo')) {
            $logo = $request->logo;
            $name_logo = time() . '.' . $logo->getClientOriginalExtension();
            $path_logo = storage_path('app/tours/upload');
            $logo->move($path_logo, $name_logo);
        }



        if ($request->has('trip_videos')) {
            $videos = $request->file('trip_videos');

            foreach ($videos as $key => $video) {
                $name_video = time() . $key . '.' . $video->getClientOriginalExtension();
                $path_video = storage_path('app/tours/upload/videos');
                $video->move($path_video, $name_video);
                $uploadedVideos[] = $name_video;
            }
        }

        $tour = ArrangeTour::findOrFail($id);
        $client_id = auth()->check() ? auth()->user()->id : null;
        if ($tour->client_id !== $client_id) {
            return response()->json([
                'message' => 'Unauthorized: You do not have permission to delete this record.',
                'status' => false,
            ], 403);
        }
        if ($tour) {
            $tour->update([
                'client_id' => auth()->check() ? auth()->user()->id : null,
                'company_name' => $request->input('company_name'),
                'price' => $request->input('price'),
                'discount' => $request->input('discount', 0),
                'from_date' => $request->input('from_date'),
                'to_date' => $request->input('to_date'),
                'day' => $request->input('day'),
                'trip_images' => $uploadedImages, // You need to define $uploadedImages
                'trip_videos' => $uploadedVideos, // Assuming 'trip_videos' is an array in the request
                'includes' => $request->input('includes'),
                'places' => $request->input('places'),
                'member' => $request->input('member'),
                'logo' =>  $name_logo,
                'star' => $request->input('star'),
                'is_deleted' => $request->input('is_deleted', false),
                'description' => $request->input('description'),
                'about_tour' => $request->input('about_tour'),
            ]);
            $updated = ArrangeTour::find($id);

            return response()->json(
                [
                    'message' => 'Update Succesfully',
                    'status' => true,
                    'data' => $updated
                ]
            );
        }

        return response()->json(['message' => 'Tour id not found', 'status' => false, 400]);
    }


    public function get()
    {
        $client_id = auth()->check() ? auth()->user()->id : null;
        $tour = ArrangeTour::where('client_id', $client_id)->get();
        $count = $tour->count();
        return response()->json([
            'status' => true,
            'message' => 'Tour data retrieved successfully',
            'total_record' => $count,
            'data' => $tour,
        ], 200);
    }

    public function delete($id)
    {
        $client_id = auth()->check() ? auth()->user()->id : null;
        $tour = ArrangeTour::find($id);

        if ($tour->client_id !== $client_id) {
            return response()->json([
                'message' => 'Unauthorized: You do not have permission to delete this record.',
                'status' => false,
            ], 403);
        }

        if ($tour) {
            $tour->delete();
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
