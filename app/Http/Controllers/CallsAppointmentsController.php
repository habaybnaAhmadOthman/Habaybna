<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
       $id = explode ("--", $slug);

        $provider = User::findorfail($id[1]) ;
        if($provider &&
        $provider->specialist &&
        !empty($provider->specialist->callsAppointments)
        )

        return response($provider->specialist->callsAppointments, 200);

        return response('notcallprovider',404);
    }

}
