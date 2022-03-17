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
                  'course_progress'=> $this->getCourseProgress($one)
                ];
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
        dd($cc->courseProgress);
        return $cc->courseProgress;
    }


}
