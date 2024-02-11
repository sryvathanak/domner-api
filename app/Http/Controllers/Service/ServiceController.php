<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Service\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    //
    public function create(Request $request){
        $request->validate([
            "code" => "required",
            "name" => "required",
         ]);

         $code_exist = Service::where('code',$request ->code)->first();
         if($code_exist)
         {
            return response([
             "message" => "Code Already Exist !",
             "success"  => false
            ],400);
         } 


         $service = Service::create($request ->all());

         return response()->json([
            "message" => "Create Successfully !",
            "success"  => true,
            "stay" => $service
           ]);
    }

    public function delete($id){
        $service = Service::find($id);
        if($service){
            $service -> delete();
            return response()->json(
            [
                'message' =>'Delete Has Success',
                'status'=>true,
            ]);
        }     
    }
    public function update(Request $request , $id){
          $service = Service::findOrFail($id);
          if($service){
            $service->update($request ->all());
            $updated=Service::find($id);

            return response()->json(
            [
            'message' =>'Update Succesfully',
            'status'=>true,
            'data' =>$updated
          ]);
          }

          return response()->json(['message' =>'Servie id not found','status'=>false,400]);
    } 
}
