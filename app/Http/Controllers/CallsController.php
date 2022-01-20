<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calls;
use App\CustomClass\createCallPackage;
use App\CustomClass\updateCallPackage;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class CallsController extends Controller
{
    public function index()
    {
        try{
            $callPackages = Calls::all();
            $data = [];
            foreach ($callPackages as $key ) {
                $data [] = [
                    'id'=>$key->id,
                    'title'=>$key->title,
                    'type'=>$key->type,
                    'status'=>$key->status,
                    'price'=>$key->price,
                    'calls_count'=>$key->calls_count,
                    'start_date'=>$key->start_date,
                    'end_date'=>$key->end_date,
                ];
            }
            // dd($data);
            return response()->json($data, 200);
        } catch (ModelNotFoundException $e){
            return response()->json(
                false,
                404
           );
        }

    }
    public function create(Request $request,createCallPackage $createCallPackage )
    {
        $coupon = $createCallPackage->execute($request->all());

        return response()->json($coupon, 200);
    }
    public function show($id)
    {

        try{
            $callPackage = Calls::findorfail($id);
            $data = [];
                $data  = [
                    'id'=>$callPackage->id,
                    'title'=>$callPackage->title,
                    'type'=>$callPackage->type,
                    'status'=>$callPackage->status,
                    'price'=>$callPackage->price,
                    'calls_count'=>$callPackage->calls_count,
                    'start_date'=>$callPackage->start_date,
                    'end_date'=>$callPackage->end_date,

                ];
            return response()->json($data, 200);
        } catch (ModelNotFoundException $e){
            return response()->json(
                false,
                404
           );
        }
    }
    public function update(Request $request,$id, updateCallPackage $updateCallPackage )
    {
        $coupon = $updateCallPackage->execute($request->all(), $id);

        return response()->json($coupon, 200);
    }
    public function changeStatus($id)
    {
        try{
            $callPackages = Calls::findorfail($id);
                    $callPackages->status = !$callPackages->status;
                    $callPackages->save();

            return response()->json('changged',200);

        } catch (ModelNotFoundException $e){
            return response()->json(
               false,
                404
           );

        }
    }
    public function delete($id)
    {
        try{
            $callPackages = Calls::findorfail($id);
            $callPackages->delete();

            return response()->json(true, 200);
        } catch (ModelNotFoundException $e){
            return response()->json(
                false,
                404
           );
        }
    }
}
