<?php
namespace app\CustomClass;

use App\AssignedCoupons;
use App\Courses;
use phpDocumentor\Reflection\Types\Object_ as TypesObject_;
use PhpParser\Node\Expr\Cast\Object_;

class AllCourses {

    public function execute()
    {
        try {
            $allCourses = Courses::where('is_publish',1)->get();

            if(count($allCourses) > 0 ){
                $data = [] ;
                foreach ($allCourses as $one) {
                    if($one->videos && count($one->videos) > 0 ){
                        $data [] = [
                            'id' => $one->id,
                            'title' => $one->courseTitle,
                            'description' => $one->courseDescription,
                            'what_should_learn' => $one->whatWeLearn,
                            'providers'=>$one->course_providers,
                            'videos_count'=>count($one->videos),
                            'videos_title_length'=>$this->getCourseVideosTitleAndLingth($one),
                            'course_length'=>$one->course_length,
                            'cover_photo'=>$one->cover_photo,
                            'is_free'=>$one->is_free,
                            'price'=>$one->price,
                            'promo_video'=>$one->url,
                            'discount'=>[
                            'has_discount'=>true,
                            'discount_value'=>"50%",
                            'discount_price'=>$one->price - $one->price * (50/100),
                            ],
                            'categories'=>$one->category_name
                        ];
                    }
                }
            }
            // dd($data);
            return $data;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function getCourseVideosTitleAndLingth($course)
    {
        if(count($course->videos->where('status',1)) > 0 ){
            $data = [] ;
            foreach ($course->videos as $one ) {
                $data [] = [
                    'lesson_id' => $one->id,
                    'lesson_title' => $one->title,
                    'lesson_length' => $one->length,
                ];
            }
            return $data ;
        }
    }






}
