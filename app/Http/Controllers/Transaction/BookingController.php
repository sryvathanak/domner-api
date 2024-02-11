<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Stay\StayResource;
use App\Http\Resources\Transaction\BookingClientResource;
use App\Http\Resources\Transaction\BookingResource;
use App\Models\Service\Service;
use App\Models\Stay\Stay;
use App\Models\Tour\ArrangeTour;
use App\Models\Transaction\Booking;
use App\Models\Transport\Bus;
use App\Models\Transport\Flight;
use App\Models\Transport\Train;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    private $client = null;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->check() ? auth()->user()->id : null;
        $booking = Booking::where('user_id', $user_id)->whereDate('check_in', '>=', Carbon::today())->get();
        $count = $booking->count();
        return response()->json([
            'status' => true,
            'message' => 'Booking data retrieved successfully',
            'total_record' => $count,
            'data' =>  BookingResource::collection($booking),
        ], 200);
    }


    public function popular()
    {
        $popularStays = Booking::whereNotNull('stay_id')
            ->select('stay_id', DB::raw('COUNT(*) as booking_count'))
            ->groupBy('stay_id')
            ->orderBy('booking_count', 'desc')
            ->get();

        $stayDetails = [];

        foreach ($popularStays as $popularStay) {
            $stay = Stay::find($popularStay->stay_id);

            if ($stay) {
                $stayDetails[] = [
                    'booking_count' => $popularStay->booking_count,
                    'stay' => (new StayResource($stay))->toOneArray(request()),

                ];
            }
        }

        return response()->json([
            'message' => 'Popular Stays Retrieved Successfully',
            'status' => true,
            'data' => $stayDetails,
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
        $checkInDate = Carbon::parse($request->check_in);
        $checkOutDate = Carbon::parse($request->check_out);
        $night = $checkOutDate->diffInDays($checkInDate);
        $request->validate([
            // 'total_price' => 'required|numeric|min:0',
            'payment_id' => 'required|numeric',
            // 'check_in' => 'required|date',
            // 'check_out' => 'required|date|after:check_in',
            'member' => 'required|integer|min:0',
        ]);


        if ($request->stay_id) {
            $this->client = Stay::find($request->stay_id);
        }
        if ($request->train_id) {
            $this->client = Train::find($request->train_id);
        }
        if ($request->bus_id) {
            $this->client = Bus::find($request->bus_id);
        }
        if ($request->flight_id) {
            $this->client = Flight::find($request->flight_id);
        }
        if ($request->trip_id) {
            $this->client = ArrangeTour::find($request->trip_id);
        }

        $book = Booking::create([
            'user_id' => auth()->check() ? auth()->user()->id : null,
            'client_id' => $this->client->client_id,
            'stay_id' => $request->stay_id,
            'bus_id' => $request->bus_id,
            'flight_id' => $request->flight_id,
            'train_id' => $request->train_id,
            'trip_id' => $request->trip_id,
            'payment_id' => $request->payment_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'room_number' => $request->room_number,
            'total_price' => $request->total_price * $night,
            'day' => $night,
            'member' => $request->member,
            'children' => $request->children,
            'age' => $request->age,
            'star' => $request->star,
            'description' => $request->description,
            'comment' => $request->comment
        ]);

        return response()->json([
            'data' => $book,
            'message' => 'Booking  Successfully',
            'status' => true,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $user_id = auth()->check() ? auth()->user()->id : null;
        $user = Booking::find($user_id);
        if ($user) {
            return response()->json([
                "message" => "Unauthorized",
                "stats" => false,

            ], 403);
        }
        $booking = Booking::find($id);
        if ($booking) {
            $booking->update(["cancell" => $request->cancell]);
            return response()->json([
                "message" => "Updated",
                "status" => true,
                "data" => $booking
            ], 200);
        }
    }

    public function get()
    {
        $client_id = auth()->check() ? auth()->user()->id : null;
        $bookings = Booking::where('client_id', $client_id)->where('cancell', 0)->whereDate('check_in', '>=', Carbon::today())->get();
        $data = BookingClientResource::collection($bookings);
        $count = $data->count();
        return response()->json([
            "meesage" => "Successfully",
            "status" => true,
            "total_record" => $count,
            "data" => $data
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
