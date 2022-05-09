<?php
namespace app\CustomClass;

use App\AssignedCoupons;
use App\Courses;
use phpDocumentor\Reflection\Types\Object_ as TypesObject_;
use PhpParser\Node\Expr\Cast\Object_;

class CourseData {

    public function execute($id)
    {
        try {
            $course = Courses::findorfail($id);
            $data['course']['course_info'] = $this->courseInfo($course);
            $data['course']['providers'] = $this->courseProviders($course);
            $data['course']['categories'] = $this->categories($course);
            $data['course']['videos'] = $course->videos;

            return $data ;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function courseInfo($course)
    {
       $course_info = [];
       $course_info['id'] = $course->id;
       $course_info['title'] = $course->courseTitle;
       $course_info['description'] = $course->courseDescription;
       $course_info['what_we_learn'] = $course-> whatWeLearn;
       $course_info['price'] = $course-> price;
       $course_info['is_publish'] = $course-> is_publish;
       $course_info['cover_photo'] = $course-> cover_photo;
       $course_info['promo_video'] = $course-> promo_video;
       $course_info['is_free'] = $course-> is_free;
       $course_info['duration'] = $course-> course_length;
       $course_info['videos_count'] = count($course-> videos);

       return $course_info;
    }

    private function categories($course)
    {
        if(count($course->category_name) > 0 ){
            return $course->category_name ;
        }
    }

    private function courseProviders($course)
    {
        if($course->course_providers &&count($course->course_providers) > 0 ){
            return $course->course_providers ;
        }
    }

}
