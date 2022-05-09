<?php
namespace app\CustomClass;

use App\AssignedCoupons;
use App\Courses;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Object_ as TypesObject_;
use PhpParser\Node\Expr\Cast\Object_;
use App\UserCourseProgress;
use App\UsersQuiz;

class AllCourses {

    public function execute()
    {
        try {
            $allCourses = Courses::where('is_publish',1)->get();

            $data = [] ;
            if(count($allCourses) > 0 ){
                foreach ($allCourses as $one) {
                    if($one->videos && count($one->videos) > 0 ){
                        $data [] =
                        [
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
                            'promo_video'=>$one->promo_video,
                            'discount'=>[
                            'has_discount'=>$one->discount > 0 ? true : false,
                            'discount_value'=>$one->discount > 0 ? $one->discount ."%" : 0,
                            'discount_price'=>$one->discount > 0 ? round($one->price - $one->price * ($one->discount/100),2):null,
                            ],
                            'categories'=>$one->category_name,
                            'course_progress' => Auth::check() ? $this->getCourseProgress($one) : [],
                            'is_favourite'=> Auth::check() && $one->favouriteUsers->count() > 0  ? true : false ,
                            'completed_course'=> Auth::check() && $this->checkExamIsPassed($one) ? true : false ,
                        ];
                    }
                }
                return $data;
            }
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

    private function getCourseProgress($one)
    {
        if( Auth::user()->user_courses > 0){
            foreach(Auth::user()->user_courses  as $course){
                if($course === $one->id)

                    return  UserCourseProgress::where('user_id',Auth::id())
                                            ->where('course_id',$one->id)->get();
            }
            return  [];

        }
        return  [];

    }

    private function checkExamIsPassed($one)
    {
        $userExamp = UsersQuiz::where('user_id',Auth::id())
                   ->where('course_id',$one->id)->first();
        if($userExamp && $userExamp != null)
            {return true ;}
            return false ;
    }
}
