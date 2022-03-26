<?php

namespace App\Http\Controllers;

use App\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use App\CustomClass\GetAllUsers;
use App\User;
use App\Specialist;
use App\UserCourseProgress;
use App\UserInterest;

// use App\Specialist;

class UserController extends Controller
{
    public function getUserData()
    {
        try{
            $user = Auth::user();
            // dd($user->user_data);
            $userIntrest = UserInterest::where('user_id',$user->id )->get() ;
            $interestsList = Interest::all();
            if($userIntrest){
                $userIntrests = [];
                foreach ($userIntrest as $intrest) {
                    $userIntrests[] =
                    [
                       'id'=> $intrest->intrest_data->id,
                       'title'=>$intrest->intrest_data->title,
                    ];
                }

            }

            switch ($user->role) {
                case 'parent':

                    $userData['firstName'] = $user->user_data->firstName ;
                    $userData['lastName'] = $user->user_data->lastName ;
                    $userData['gender'] = $user->user_data->gender ;
                    $userData['dob'] = $user->user_data->dob ;
                    $userData['avatar'] = $user->user_data->avatar ;
                    $userData['status'] = $user->user_data->status ;
                    $userData['relative'] = $user->user_data->relative ;
                    $userData['childs_count'] = $user->user_data->childs_count ;
                    $userData['speci_childs_count'] = $user->user_data->speci_childs_count ;
                    $userData['edu_level'] = $user->user_data->edu_level ;
                    $userData['city'] = $user->user_data->city ;
                    $userData['employment'] = $user->user_data->employment ;
                    $userData['job_title'] = $user->user_data->job_title ;
                    $userData['why_to_join'] = $user->user_data->why_to_join ;
                    $userData['private_mode'] = $user->user_data->private_mode ;
                    $userData['interests'] = $userIntrests ? $userIntrests : '';
                    $userData['interestsList'] = $interestsList ? $interestsList : [];



                    $userData['phone'] = $user->phone ;
                    $userData['email'] = $user->email ;

                    break;

                case 'specialist':

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
                    $userData['city'] = $user->user_data->city ;
                    $userData['experience'] = $user->user_data->experience ;
                    $userData['disorders_work_with'] = $user->user_data->disorders_work_with ;
                    $userData['interests'] = $userIntrests ? $userIntrests : '';
                    $userData['interestsList'] = $interestsList ? $interestsList : [];



                    $userData['phone'] = $user->phone ;
                    $userData['email'] = $user->email ;

                case 'other':
                    $userData['firstName'] = $user->user_data->firstName ;
                    $userData['lastName'] = $user->user_data->lastName ;
                    $userData['gender'] = $user->user_data->gender ;
                    // $userData['specialization'] = $user->user_data->specialization ;
                    $userData['work_place'] = $user->user_data->work_place ;
                    $userData['status'] = $user->user_data->status ;
                    $userData['avatar'] = $user->user_data->avatar ;
                    $userData['edu_level'] = $user->user_data->edu_level ;
                    $userData['job_title'] = $user->user_data->job_title ;
                    $userData['dob'] = $user->user_data->dob ;
                    $userData['why_to_join'] = $user->user_data->why_to_join ;
                    $userData['employment'] = $user->user_data->employment ;
                    $userData['interests'] = $userIntrests ? $userIntrests : '';
                    $userData['interestsList'] = $interestsList ? $interestsList : [];


                    $userData['phone'] = $user->phone ;
                    $userData['email'] = $user->email ;
            }
                return response()->json([
                    'msg'=>'success',
                    'userData'=>$userData,
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

    public function setNewPassword(Request $request)
    {
        $oldPassword = $request->oldPassword;
        $hashedPassword = Auth::user()->password;  // Taking the value from database

        if(Hash::check($oldPassword, $hashedPassword))
        {
             Auth::user()->password = Hash::make($request->newPassword) ;
             Auth::user()->save();

            return response()->json([
                'msg'=>'success',
                'status'=>true,
                200
            ]);
        }
        else
        {
            return response()->json([
                'msg'=>'old password not correct',
                'status'=>false,



           ],404);
        }
    }

    public function editProfileImage(Request $request)
    {
        if ($request->hasFile('url')) {
            try{

                $user = Auth::user()->user_data;

                if($user){
                    $profileImage = $request->file('url');
                    $imageName = 'user-'. $user->id . '-' . $profileImage->getClientOriginalName();
                    $pathImg = $profileImage->storeAs('public/images/profileImages', $imageName);
                    $url = url('/storage/images/profileImages/'.$imageName);
                    $user->avatar =  $url;
                    $user->save();
                    return response()->json([
                        'status'=>true,
                        'msg'=>'success',
                        'url'=>$url
                    ]);
                }


            } catch (ModelNotFoundException $e){
                return response()->json([
                    'msg'=>'faild',
                    'status'=>false,
                    404
               ]);

        }



            }
    }

    public function delete($id)
    {
        try{
            $user = User::findorfail($id);
                if($user->user_data){
                    $user->user_data->delete();
                }

            $userIntrests = UserInterest::where('user_id',$id)->get();
            if(count($userIntrests) > 0){
                foreach ($userIntrests as $one) {
                   $one->delete();
                }
            }

            $user->delete();

            return response()->json('deleted',200);

        } catch (ModelNotFoundException $e){
            return response()->json([
                'msg'=>'faild',
                'status'=>false,
                404
           ]);

    }
    }

    public function changeStatus($id)
    {
        try{
            $user = User::findorfail($id);
                if($target = $user->user_data){
                    $target->status = !$target->status;
                    $target->save();
                }

            return response()->json('changged',200);

        } catch (ModelNotFoundException $e){
            return response()->json([
                'msg'=>'faild',
                'status'=>false,
                404
           ]);

        }
    }

    public function getAllUsers(GetAllUsers $getAllUsers)
    {
        $users = $getAllUsers->execute();

        return response()->json($users, 200);

    }

    public function userCourses()
    {
        return response( Auth::user()->user_courses,200) ;
    }

    public function setVideoActions(Request $request)
    {
        // User::findorfail(48)
        $order = Auth::user()->coursePurchaseOrder->where('course_id',$request->courseID)->first();
        if(!$order) {
            return response(['msg'=>'nocourse','status'=>403]);
        }
        // dd($request->videoID ,  $request->courseID,$order->id,$request->isComplete,$request->inProgress);
        // Auth::user()->userVideoProgress->updateOrCreate(
        //     ['video_id' => $request->videoID , 'user_id' => Auth::id(), 'course_id' => $request->courseID, 'order_id' =>$order->id ],
        //     ['in_progress' => '35:5', 'is_complete' =>  0]
        // );
        $prgr = UserCourseProgress::where('order_id',$order->id)
                                    ->where('user_id',Auth::id())
                                    ->where('video_id',$request->videoID)->first();
                if($request->type == "progress"){
                    if($prgr && $prgr != null){
                        $prgr->in_progress = $request->inProgress ;
                        $prgr->save();
                    }
                    else{
                        $prgr = new UserCourseProgress();

                        $prgr->video_id = $request->videoID;
                        $prgr->user_id = Auth::id();
                        $prgr->course_id = $request->courseID;
                        $prgr->in_progress = $request->inProgress;
                        $prgr->is_complete = 0;
                        $prgr->order_id = $order->id;
                        $prgr->save();

                    }
                }
                if($request->type == "isComplete"){
                    if($prgr && $prgr != null){
                        $prgr->in_progress = '100' ;
                        $prgr->is_complete = 1;

                        $prgr->save();
                    }
                    else{
                        $prgr = new UserCourseProgress();

                        $prgr->video_id = $request->videoID;
                        $prgr->user_id = Auth::id();
                        $prgr->course_id = $request->courseID;
                        $prgr->in_progress = '100';
                        $prgr->is_complete = 1;
                        $prgr->order_id = $order->id;
                        $prgr->save();

                    }
                }


        // $data = Auth::user()->userVideoProgress->where('order_id',$order->id)->get();

        // if(!$data){
        //     return response(['msg'=>'something went wronge try again ','status'=>403]);
        // }

        // $data->makeHidden(['created_at','updated_at','user_id','order_id','id']);

        return response([$prgr,200]);

    }
}
