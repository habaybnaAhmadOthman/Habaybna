<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CallsStatus;
use App\CallPurchaseOrders;
use App\CallsAppointments;
use App\Specialist;
use App\User;

use Auth;
use \Carbon\Carbon;


class CallsAppointmentsController extends Controller
{

    public function setCallsProvidersappointments(Request $request)
    {
        if(Auth::user()->specialist && Auth::user()->specialist->make_calls){
            $data['apointments'] = $request->all();

            if(!empty($data['apointments']) && count($data['apointments']) > 0 ){

                foreach ($data['apointments'] as $one) {
                    CallsAppointments::create([
                        'specialist_id'=>Auth::id(),
                        'appointment'=>$one
                    ]);
                }
                return response(Auth::user()->specialist->callsAppointments, 200);
            }
        }
        return response('cantmakecall', 404);


    }

    public function getBookedCallsProvidersappointments()
    {
        $provider = User::findorfail(7) ;

        if($provider && $provider->specialist)

        return response($provider->specialist->callsAppointments, 200);

        return response('notcallprovider',404);
    }

    public function getCallsProvidersappointments($slug)
    {
        // dd($slug);
       $id = explode ("--", $slug);
        $provider = User::findorfail($id[1]) ;
        if($provider &&
        $provider->specialist &&
        !empty($provider->specialist->callsAppointments)
        )

        return response($provider->specialist->availiableAppointments, 200);

        return response('notcallprovider',404);
    }

    public function getSpecialistCallLog(Request $request)
    {
        // $log = CallsAppointments::whereHas('callsStatus', function ( $q ) use ($request) {
        //     dd($q->first());
        // });
        $log = CallsAppointments::whereHas('callsStatus', function ($q) use ($request){

            // if($request->filters && $request->filters )
            // $q->where('status',$request->filters);
        })->with('callsStatus','appointmentChildInfo')
          ->where('specialist_id', Auth::id());

          if(isset($request->filters)) {
            $log->whereHas('callsStatus', function ($q) use ($request){

                // if($request->filters && $request->filters )
                $q->where('status',$request->filters);
            });
          }


          return response(
              $log->orderBy('id', 'desc')->paginate(12),
              200
            );
    }

    public function getUserCallLog(Request $request)
    {
        $log = CallsAppointments::whereHas('callsStatus', function ($q) use ($request){

        })->whereHas('callPurchaseOrders', function ($o) use ($request){
            $o->where('user_id',Auth::id());
        })
        ->with('callsStatus','appointmentChildInfo');
        //   ->where('specialist_id', Auth::id());

          if(isset($request->filters)) {
            $log->whereHas('callsStatus', function ($q) use ($request){

                $q->where('status',$request->filters);
            });
          }


          return response(
              $log->orderBy('id', 'desc')->paginate(12),
              200
            );
    }

    public function removeAppointment(Request $request)
    {
        $appointment = CallsAppointments::where('id',$request->id)->delete();

        return response('success', 200);
    }

    public function getCallsAppointments(Request $request)
    {
        $log = CallsAppointments::whereHas('callsStatus', function ($q) use ($request){

        })
        // ->whereHas('callPurchaseOrders',function($q){
        //     $q->with('users')->get();
        // })
        ->with('callsStatus','appointmentChildInfo','specialist','callPurchaseOrders');
        //   ->where('specialist_id', Auth::id());

          if(isset($request->filters)) {
            $log->whereHas('callsStatus', function ($q) use ($request){

                // if($request->filters && $request->filters )
                $q->where('status',$request->filters);
            });
          }


          return response(
              $log->orderBy('id', 'desc')->paginate(15),
              200
            );
    }

    public function setZoomLink(Request $request)
    {
        $appointment = CallsStatus::where('appointment_id',$request->appointmentID)->first() ;

        if(isset($appointment) ) {
            $appointment->call_zoom_link = $request->zoomLink ;
            $appointment->save();

            // we need add sms event
                // here

            return response('success', 200);
        }

        return response('faild', 404);



    }

    public function ChangeAppointmnetStatus(Request $request)
    {
        $appointment = CallsStatus::where('appointment_id',$request->appoID)->first() ;

        if(isset($appointment) ) {
            $appointment->status = $request->status ;
            $appointment->save();

            return response('success', 200);
        }

        return response('faild', 404);



    }
}
