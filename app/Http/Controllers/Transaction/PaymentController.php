<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->check() ? auth()->user()->id : null;
        $payment = Payment::where('user_id', $user_id)->get();
        $count = $payment ->count();
          return response()->json([
              'status' => true,
              'message' => 'Payment data retrieved successfully',
              'total_record' => $count,
              'data' => $payment,
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
        $request->validate([
            'account_name' => 'required|alpha',
            'account_number' => 'required|numeric|digits:16',
            'expired_month' => [
                'required',
                'numeric',
                'digits:2',
                function ($attribute, $value, $fail) {                 
                    $expiryDate = \DateTime::createFromFormat('ym', sprintf('%02d%02d', request('expired_year'), $value));      
                    if ($expiryDate < new \DateTime()) {
                        $fail('The expiry date must be in the future.');
                    }
                },
            ],
            'expired_year' => 'required|numeric|digits:2',
            'cvv' => 'required|numeric|digits:3',
        ]);
        
        
        $user_id = auth()->check() ? auth()->user()->id : null; 
        $payment = Payment::create([
            "user_id" => $user_id,
            "account_name" => $request->account_name,
            "account_number"=>$request ->account_number,
            "expired_month"=>$request ->expired_month,
            "expired_year"=>$request ->expired_year,
            "cvv" =>$request->cvv,
            "payment_method"=>$request ->payment_method
        ]);

        return response()->json([
            "message" => "Created Successfully",
            "status" => true,
            "date" => $payment
        ]);

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
    public function destroy($id)
    {
        $user_id = auth()->check() ? auth()->user()->id : null;
        $payment = Payment::find($id);

        if ($payment->user_id !== $user_id) {
            return response()->json([
                'message' => 'Unauthorized: You do not have permission to delete this record.',
                'status' => false,
            ], 403);
        }
        if($payment){
            $payment -> delete();
            return response()->json(
            [
                'message' =>'Delete Has Success',
                'status'=>true,
            ],200);
        }  
        return response()->json(
            [
                'message' =>'Not Found',
                'status'=>false,
            ],400);   
    }
}
