<?php

namespace app\CustomClass;
use Illuminate\Support\Facades\Http;
use App\Coursespurchaseorders;
use Illuminate\Support\Facades\Auth;
class GetCoursesOrders {

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
                // if($one->status){
                $sortedData[]=[
                  'order_id'=>$one->id,
                  'course_title'=>$one->course->courseTitle,
                  'course_categories'=>$one->course->category_name,
                  'order_status'=>$one->status,
                  'course_length'=>$one->course->course_length,
                  'course_price'=>$one->amount,
                  'user_name'=>$one->user->user_data->firstName,
                  'user_phone'=>$one->user->phone,
                  'date'=>$one->created_at->format('Y-m-d'),
                  'course_progress'=> $this->getCourseProgress($one),
                  'coupon'=> $one->coupon ? $one->coupon->usage . '-' .$one->coupon->type : null,
                ];
            // }
            }
            return $sortedData;
        }

        } catch (\Throwable $th) {
            dd($th);
            return response(false, 404) ;
        }
    }

    private function getCourseProgress($cc)
    {
        $progress = [] ;
        if(!$cc->status){
            return $progress ;
        }
        if(count($cc->course_videos_progress) > 0){
            foreach ($cc->course_videos_progress as $key) {
                if(!$key['is_complete'] == 1){
                    $progress['is_complete']=false;
                    $progress['inprogress']=true;
                    break;
                }
                $progress['is_complete']=true;
            }
            return $progress;
        }

    }


}
