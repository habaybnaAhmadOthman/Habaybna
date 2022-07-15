<?php

namespace app\CustomClass;
use Illuminate\Support\Facades\Http;
use App\Coursespurchaseorders;
use App\UserCourseProgress;
use App\UsersQuiz;
use Illuminate\Support\Facades\Auth;
class GetUsersCourseProgress {

    public function execute()
    {
        try {

            $allOrders = Coursespurchaseorders::all();
            $data = $this->getOrdersData($allOrders);
            return $data;

        } catch (\Throwable $th) {
            return response(false, 404) ;
        }

    }

    private function getOrdersData($data)
    {
       try {
        if($data->count() > 0){
            $sortedData = [] ;
            foreach ($data as $one) {
                if($one->status && $one->user && $one->user->user_data && $one->course){
                    $sortedData[]=[
                        'order_id'=>$one->id,
                        'course_title'=>$one->course->courseTitle,
                        'course_videos_count'=>$one->course->videos->count(),
                        'completed_videos_count'=>$this->getCompletedLessones($one),
                        'complete_lessons_perc'=>round(($this->getCompletedLessones($one)/$one->course->videos->count()) * 100) . " %",
                        // 'completed_videos_count'=>$this->getCompletedLessonesPerc(),
                        // 'user_name'=>$one->user->user_data->firstName,
                        'user_name'=>$one->user->user_data->firstName .' '. $one->user->user_data->lastName,
                        'user_phone'=>$one->user->phone,
                        'user_email'=>$one->user->email,
                        'date'=>$one->created_at->format('Y-m-d'),
                        'course_status'=>$this->getCourseStatus($one)
                      ];
                }
                // if($one->status){

            // }
            }
            return $sortedData;
        }

        } catch (\Throwable $th) {
            dd($th);
            return response(false, 404) ;
        }
    }

    private function getCourseStatus($cc)
    {


        if($cc){
            $quizStatus = UsersQuiz::where('user_id',$cc->user_id)->where('course_id',$cc->course_id)->first();

            if($quizStatus && $quizStatus->is_complete){

                return 'تم انهاء الدورة';
            }

            elseif( $progress = UserCourseProgress::where('order_id',$cc->id)->count() > 0 ){

                if(UserCourseProgress::where('order_id',$cc->id)->count() < $cc->course->videos->count()){
                    return ' لم يتم انهاء الدورة';
                }

                elseif(UserCourseProgress::where('order_id',$cc->id)->count() == $cc->course->videos->count()){
                    return ' لم يتم اجتياز الاختار';
                    }
        }  else{
                return '    الدورة لم تبدأ';
                }


        }
        // if(count($cc->course_videos_progress) > 0){
        //     foreach ($cc->course_videos_progress as $key) {
        //         if(!$key['is_complete'] == 1){
        //             $progress['is_complete']=false;
        //             $progress['inprogress']=true;
        //             break;
        //         }
        //         $progress['is_complete']=true;
        //     }
        //     return $progress;
        // }

    }
    private function getCompletedLessones($one)
    {
        $count = UserCourseProgress::where('order_id',$one->id);
        return $count->count();
    }




}
