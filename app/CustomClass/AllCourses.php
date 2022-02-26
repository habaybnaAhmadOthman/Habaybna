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
                    $data [] = [
                        'course_id' => $one->id,
                        'title' => $one->courseTitle,
                    ];
                }
            }
            dd($data);

        } catch (\Throwable $th) {
            throw $th;
        }
    }







}
