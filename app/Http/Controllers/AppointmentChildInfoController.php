<?php

namespace App\Http\Controllers;

use App\AppointmentChildInfo;
use Illuminate\Http\Request;

class AppointmentChildInfoController extends Controller
{
    public function setAppintmentChildInfo(Request $request)
    {
        $appointment_info = AppointmentChildInfo::findorfail($request->callID);
        $appointment_info->discovered_age = $request -> age;
        $appointment_info->age = $request -> birthdate ;
        $appointment_info->child_situation = $request -> childSituation ;
        $appointment_info->child_status = $request -> childStatus ;
        $appointment_info->message = $request -> message ;

        $appointment_info->save ();

        return response('success', 200);
    }

    public function setCallRecommendation(Request $request)
    {
        $appointment_info = AppointmentChildInfo::findorfail($request->callID);

        $appointment_info->recommendation = $request -> message ;

        $appointment_info->save ();

        // event [send email to parent by the recmmendation]

        return response('success', 200);
    }
}
