<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialist;
use App\Speciality;
use App\Interest;
use App\UserInterest;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\SpecialistZoomAccount;
use Stevebauman\Location\Facades\Location;






class SpecialistController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'fristName' => ['required', 'string'],
            'lastName' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'specialization' => ['required', 'string'],
            'workPlace' => ['required', 'string'],
            'password' => ['required', 'string','min:8'],
           ]);

           Auth::user()->email = $request->email;
           Auth::user()->password = Hash::make($request->password);
           Auth::user()->is_verify = 1 ;


           Auth::user()->save();

           // add country
           try {
            $position = Location::get(request()->ip());
            Auth::user()->country = $position->countryName ;
            Auth::user()->save();

        } catch (\Throwable $th) {
            // throw $th;
        }
        // create specialist
        Auth::user()->specialist()->create([
            // 'user_id' => Auth::user()->id,
            'firstName' => $request->fristName,
            'lastName' => $request->lastName,
            'gender' => $request->gender,
            'specialization' => $request->specialization,
            'work_place' => $request->workPlace,
            'can_make_comments' => 0,

        ]);

        // add inetrest
        $interest = Interest::all();
        $mailChimpData =[
            'email'=> Auth::user()->email,
            'phone'=> Auth::user()->phone,
            'firstName'=> Auth::user()->specialist->firstName,
            'lastName'=> Auth::user()->specialist->lastName,
            'tag'=> 'new user',
            'type'=> Auth::user()->role,
        ];

        // subscribe user
        mailerLiteSubscribe($mailChimpData);
        return response()->json([
            'msg'=>'success',
            'status'=>true,
            'userData'=>Auth::user(),
            'intrest'=>$interest,
            200
        ]);
    }

    public function createSpecAdmin(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'firstName' => ['required', 'string'],
            'lastName' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'specialization' => ['required', 'string'],
            'password' => ['required', 'string','min:8'],
           ]);

           $user = new User();
            $user->phone = '+'.$request->phone ;
            $user->email = $request->email ;
            $user->password = Hash::make($request->password);
            $user->otp = '123432' ;
            $user->role = 'specialist' ;
            $user->is_verify = 1 ;

            $user->save();

            if($user){
                $specialist = new Specialist();

                $specialist->firstName = $request->firstName;
                $specialist->lastName = $request->lastName;
                $specialist->gender = $request->gender;
                $specialist->user_id = $user->id;
                $specialist->specialization = $request->specialization;
                $specialist->work_place = " ";

                $specialist->save();

                // send password by email to the parent

                return response()->json(
                    $user->user_data,
                    200
                );


            }
    }
    public function editProfileData(Request $request)
    {
        try{

            $specialist = Auth::user()->user_data ;

            if(count($request->interests) > 0 ){
                $oldInterest = UserInterest::where('user_id',Auth::id() )->get() ;

                if(count($oldInterest) > 0 ){
                    foreach ($oldInterest as $old) {
                    $old->delete();
                    }
                }

                foreach ($request->interests as $interest) {
                    $userInterest = new UserInterest();
                    $userInterest->user_id = Auth::id();
                    $userInterest->interest_id = $interest;

                    $userInterest->save();
                 }


            }

            $specialist->dob = $request->dob ;
            $specialist->city = $request->city ;
            $specialist->specialization = $request->specialization ;
            $specialist->work_place = $request->workPlace ;
            $specialist->job_title = $request->jobTitle ;
            $specialist->experience = $request->experience ;
            $specialist->gender = $request->gender ;
            $specialist->disorders_work_with = $request->whyToJoin ;
            $specialist->edu_level = $request->education ;

            // interest

            $specialist->save();

            return response()->json([
                'msg'=>'success',
                'status'=>true,
                200
           ]);
         } catch (ModelNotFoundException $e){

            return response()->json([
                'msg'=>'faild',
                'status'=>false,
                404

           ]);
           }
    }

    public function getSpecialistsData()
    {
        try{

            $specialists = User::whereHas('specialist')->orderBy('id', 'desc')->paginate(15);
            return response($specialists, 200);

        } catch (ModelNotFoundException $e){
            return response( 'error',404 );
        }



    }

    public function show($id)
    {
        try {
            $user = User::findorfail($id);
            $userIntrest = UserInterest::where('user_id',$user->id )->get() ;
            $interestsList = Interest::all();

            if($userIntrest){
                $userIntrests = [];
                foreach ($userIntrest as $one) {
                    $userIntrests[] =
                    [
                    'id'=> $one->intrest_data->id,
                    'title'=>$one->intrest_data->title,
                    ];
                }

            }

            $userData['firstName'] = $user->user_data->firstName ;
            $userData['lastName'] = $user->user_data->lastName ;
            $userData['gender'] = $user->user_data->gender ;
            $userData['specialization'] = $user->user_data->specialization ;
            $userData['work_place'] = $user->user_data->work_place ;
            $userData['status'] = $user->user_data->status ;
            $userData['avatar'] = $user->user_data->avatar ;
            $userData['edu_level'] = $user->user_data->edu_level ;
            $userData['job_title'] = $user->user_data->job_title ;
            $userData['dob'] = $user->user_data->dob ;
            $userData['experience'] = $user->user_data->experience ;
            $userData['disorders_work_with'] = $user->user_data->disorders_work_with ;
            $userData['interests'] = $userIntrests ? $userIntrests : '';
            $userData['interestsList'] = $interestsList ? $interestsList : [];



            $userData['phone'] = $user->phone ;
            $userData['email'] = $user->email ;
            return response()->json([
                'msg'=>'success',
                'userData'=>$userData,
                'status'=>true,
                200
            ]);

        }catch (ModelNotFoundException $e){
            return response()->json([
                'msg'=>'faild',
                'status'=>false,
                404
           ]);
        }
    }

    public function update(Request $request, $id)
    {
        try{

            $specialist = Specialist::where('user_id',$id)->first();

            if(count($request->interests) > 0 ){
                $oldInterest = UserInterest::where('user_id',$id )->get() ;

                if(count($oldInterest) > 0 ){
                    foreach ($oldInterest as $old) {
                    $old->delete();
                    }
                }

                foreach ($request->interests as $interest) {
                    $userInterest = new UserInterest();
                    $userInterest->user_id = $id;
                    $userInterest->interest_id = $interest;

                    $userInterest->save();
                 }


            }

            $specialist->dob = $request->dob ;
            $specialist->specialization = $request->specialization ;
            $specialist->work_place = $request->workPlace ;
            $specialist->job_title = $request->jobTitle ;
            $specialist->experience = $request->experience ;
            $specialist->gender = $request->gender ;
            $specialist->disorders_work_with = $request->whyToJoin ;
            $specialist->edu_level = $request->education ;

            // interest

            $specialist->save();

            return response()->json([
                'msg'=>'success',
                'status'=>true,
                200
           ]);
         } catch (ModelNotFoundException $e){

            return response()->json([
                'msg'=>'faild',
                'status'=>false,
                404

           ]);
           }
    }

    public function makeCallStatus($id)
    {
        $spec = Specialist::where('user_id',$id)->first();

        if(isset($spec) && $spec != null) {

            $spec->make_calls = !$spec->make_calls ;
            $spec->save();
            return response('success', 200);
        }

        return response('faild', 404);


    }

    public function callsProvidersList(Request $request)
    {
        $specialists = User::whereHas('specialist',function($q) {

            $q->canMakeCalls();
            $q->where('status',1);
            // $q->whereHas('availiableAppointments');

        });
        if( isset($request->filters) ) {
            $explode_id =  explode(',', $request->filters);
            $specialists = User::whereHas('specialist',function($q) use ($explode_id){

                $q->canMakeCalls();
                $q->where('status',1);
            // $q->whereHas('availiableAppointments');

                $q->whereIn('specialization',$explode_id);

            });
            // dd($specialists->get());


        }


        return response(
            $specialists->with('specialist')
                ->paginate(12)  ,
            200
        );
    }

    public function getSpeciality()
    {
        $speciality = Speciality::all();
        return response($speciality, 200);
    }

    public function exportToExcel()
    {
        try{
                $parents = User::whereHas('specialist')->where('role','specialist')->with('specialist')->orderBy('id', 'desc')->get();
                return response($parents, 200);

            } catch (ModelNotFoundException $e){
                return response( 'error',404 );
            }

    }

    public function addZoomAccount(Request $request)
    {
        if(Auth::user() && Auth::user()->role == 'specialist' ) {
            $specZoomLink =  SpecialistZoomAccount::updateOrCreate(
                ['spec_id' => Auth::id()],
                [
                    'zoom_link' => $request->zoomLink,
                    'meeting_id' => $request->meetingID,
                    'password' => $request->password,
                    'status' => 1,
                ]
            );

            if($specZoomLink) {
                return response($specZoomLink, 200);
            }
            return response(404);

        }

    }

    public function getZoomAccount()
    {
        $zoomAccount = SpecialistZoomAccount::where('spec_id',Auth::id())->get();
        if($zoomAccount && count($zoomAccount) > 0)
            return response($zoomAccount, 200);

            return response($zoomAccount, 204);
    }

}
