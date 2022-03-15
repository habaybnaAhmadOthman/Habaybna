<?php
namespace app\CustomClass;

use App\Courses;
use App\Coursespurchaseorders;
use Illuminate\Support\Facades\Auth;




class GetUserCourses {

    public function execute($data)
    {
        try {
            $CourseOrder = Coursespurchaseorders::where('user_id',Auth::id())
            ->where('course_id',$data['courseID'])
            ->where('status',1)
            ->first();
            if(isset($CourseOrder)){

                if(isset($CourseOrder->course)){

                    if(isset($CourseOrder->course->videos) && $CourseOrder->course->videos->count() > 0){

                        return $CourseOrder->course->videos ;
                    }

                    // return ['status'=>false,
                    //  404];
                }
                // return ['status'=>false,
                // 404];
            }
            // return ['status'=>false,
            // 404];


        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
