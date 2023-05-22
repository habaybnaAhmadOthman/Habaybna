<?php

namespace App\Http\Controllers;

use App\ParentUsers;
use App\User;
use App\Interest;
use App\UserInterest;
use Illuminate\Http\Request;
use App\Events\TestEvent;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use phpDocumentor\Reflection\Types\Parent_;
use Stevebauman\Location\Facades\Location;


class ParentUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // dd('xxxxxxxx');
        // $this->middleware('auth:sanctum');
    }


    public function index()
    {
        // parents dashboard
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       $request->validate([
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'firstName' => ['required', 'string'],
        'lastName' => ['required', 'string'],
        'gender' => ['required', 'string'],
        'relative' => ['required', 'string'],
        'password' => ['required', 'string','min:8'],
       ]);
       $request->session()->get('user.phone')->validate([
        'phone' => ['required', 'unique:users'],
       ]);
       $user = new User();
        $user->phone = $request->session()->get('user.phone');
        $user->email = $request->email ;
        $user->password = Hash::make($request->password);
        $user->otp = '123432' ;
        $user->role = 'parent' ;
        $user->is_verify = 1 ;

        $user->save();

       Auth::login($user);
        if($user){
            $parent = new ParentUsers();

            $parent->firstName = $request->firstName;
            $parent->lastName = $request->lastName;
            $parent->gender = $request->gender;
            $parent->user_id = $user->id;
            $parent->relative = $request->relative;

            $parent->save();

            // send password by email to the parent

            return response()->json(
                $user->user_data,
                200
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ParentUsers  $parentUsers
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
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
        // dd($user->user_data);
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
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ParentUsers  $parentUsers
     * @return \Illuminate\Http\Response
     */
    public function edit(ParentUsers $parentUsers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ParentUsers  $parentUsers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try{
            $parent = ParentUsers::where('user_id',$id)->first();

            if(count($request->interests) > 0 ){


                foreach ($request->interests as $interest) {
                    if( UserInterest::where('user_id',$id )->where('interest_id',$interest)->first() )
                        continue ;
                    $userInterest = new UserInterest();
                    $userInterest->user_id = $id;
                    $userInterest->interest_id = $interest;

                    $userInterest->save();
                 }

                 $deletedInterests = UserInterest::where('user_id',$id )->whereNotIn('interest_id',$request->interests)->get();
                 if(count($deletedInterests) > 0) {
                     foreach ($deletedInterests as $key ) {
                         $key->delete();
                     }
                 }

            }else {

                $oldInterest = UserInterest::where('user_id',$id )->get() ;
                if(count($oldInterest) > 0 ){
                    foreach ($oldInterest as $old) {
                    $old->delete();
                    }
                }
            }


            $parent->dob = $request->dob ;
            $parent->lastName = $request->lastName ;
            $parent->relative = $request->relative ;
            $parent->speci_childs_count = $request->noChildsSpecialNeeds ;
            $parent->why_to_join = $request->whyToJoin ;
            $parent->city = $request->city ;
            $parent->childs_count = $request->noChilds ;
            $parent->edu_level = $request->education ;
            $parent->employment = $request->employment ;
            $parent->job_title = $request->jobTitle ;

            $parent->save();

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ParentUsers  $parentUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParentUsers $parentUsers)
    {
        //
    }

    public function completeRegister(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'firstName' => ['required', 'string'],
            'lastName' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'relative' => ['required', 'string'],
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

                // create paretn
                Auth::user()->parent()->create([
                    'firstName' => $request->firstName,
                    'lastName' => $request->lastName,
                    'gender' => $request->gender,
                    'relative' =>  $request->relative,
                ]);


        $interest = Interest::all();
        $mailChimpData =[
            'email'=>Auth::user()->email,
            'phone'=>Auth::user()->phone,
            'firstName'=> Auth::user()->parent->firstName,
            'lastName'=> Auth::user()->parent->lastName,
            'tag'=> 'new user',
            'type'=>Auth::user()->role,
        ];
        mailerLiteSubscribe($mailChimpData);
        return response()->json([
            'msg'=>'success',
            'status'=>true,
            'userData'=>Auth::user(),
            'intrest'=>$interest,
            200
        ]);
    }

    public function editProfileData(Request $request)
    {
        try{
            $parent = Auth::user()->user_data ;
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

            if(count($request->interests) > 0 ){
                $oldInterest = UserInterest::where('user_id', Auth::user()->id )->get() ;

                if(count($oldInterest) > 0 ){
                    foreach ($oldInterest as $old) {
                    $old->delete();
                    }
                }

                foreach ($request->interests as $interest) {
                    $userInterest = new UserInterest();
                    $userInterest->user_id =  Auth::user()->id;
                    $userInterest->interest_id = $interest;

                    $userInterest->save();
                 }


            }
            $parent->dob = $request->dob ;
            $parent->lastName = $request->lastName ;
            $parent->relative = $request->relative ;
            $parent->speci_childs_count = $request->noChildsSpecialNeeds ;
            $parent->why_to_join = $request->whyToJoin ;
            $parent->city = $request->city ;
            $parent->childs_count = $request->noChilds ;
            $parent->edu_level = $request->education ;
            $parent->employment = $request->employment ;
            $parent->job_title = $request->jobTitle ;

            $parent->save();

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


    public function setPrivateMode(Request $request)
    {
        try{
            $parent = Auth::user()->user_data ;

            $parent->private_mode = $request->isPrivateMode ;
            if($request->isPrivateMode){

                $nickName = 'habaybnaUser_'.random_int(100000, 999999);
                $parent->nick_name = $nickName;
            }

            $parent->save();

            return response()->json([
                'msg'=>'success',
                'status'=>true,
                'nickName'=>$nickName,
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

    public function getParentsData()
    {
        try{
            //  event(new TestEvent('hello world'));


            $parents = User::with('parent')
                                ->whereHas('parent',function(Builder $q) {

                                })->where('role','parent')->orderBy('id', 'desc')->paginate(15);

                return response($parents, 200);

            } catch (ModelNotFoundException $e){
                return response( 'error',404 );
            }

    }

    public function exportToExcel()
    {
        try{
                $parents = User::whereHas('parent')->with('parent')->orderBy('id', 'desc')->get();

                return response($parents, 200);

            } catch (ModelNotFoundException $e){
                return response( 'error',404 );
            }

    }




}
