<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Courses;
use App\Specialist;
use App\Quize;
use App\CourseCategory;
use App\CourseVideos;
use App\CourseSpecialist;
use App\CategoryCourse;
use App\Question;
use App\CustomClass\CourseData;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Owenoj\LaravelGetId3\GetId3;


class CourseController extends Controller
{
   public function index(Request $request)
   {
            $courses = Courses::select('id','courseTitle', 'category_id', 'price', 'is_publish', 'is_free')->get();
            $data=[];

            foreach ($courses as $one) {
                $data[] =[
                    'course_id' => $one->id,
                    'courseTitle' => $one->courseTitle,
                    'courseCategory' => $one->category_name,
                    'videosCount' => $one->category_name,

                    'publish' => $one->is_publish ? 'منشورة' : 'غير منشورة',
                    'free' => $one->is_free ? 'مجانية' : 'مدفوعة',
                    'coursePrice'=>$one->price,
                    'videos_count'=>count($one->videos),
                    'course_length'=>$one->course_length,
                ];
            }
            return response()->json([
                'courses' => $data,
                'status'=>true,
            ],200);
   }

   public function create()
   {
    //    return view ('admin.courses.create',['categories'=>$categories]);
   }

   public function storeCourseInfo(Request $request)
   {
    //    dd($request->category);
       $course = new Courses();

       if ($request->hasFile('coverImage')) {
        $coverImage = $request->file('coverImage');
        $imageName = 'courseCoverImg' . '-' . $coverImage->getClientOriginalName();
        $pathImg = $coverImage->storeAs('public/images/courseCoverImg', $imageName);

        $coverUrl = url('/storage/images/courseCoverImg/'.$imageName);

        }
        if ($request->hasFile('promoVideo')) {
            $promoVideo = $request->file('promoVideo');
            $videoName = 'coursePromoVideo' . '-' . $promoVideo->getClientOriginalName();
            $pathVid = $promoVideo->storeAs('public/videos/promoVideo', $videoName);
            $promoUrl = url('/storage/videos/promoVideo/'.$videoName);

        }

       $course->courseTitle = $request->title;
       $course->courseDescription= $request->description;
    //    $course->category_id= $request->category;
       $course->whatWeLearn= $request->watWeLearn;
       $course->is_publish= $request->is_publish;
       $course->is_free= $request->is_free;
       $course->price= $request->price;
       $course->promo_video= $promoUrl ? $promoUrl : '';
       $course->cover_photo = $coverUrl ? $coverUrl: '';

       $course->save();

       if($request->has('category')){
        $categories = explode( ',', $request->category );

        foreach ($categories as $one) {
            $categoryCourse = new CategoryCourse();
            $categoryCourse->course_id = $course->id;
            $categoryCourse->cat_id = $one;
            $categoryCourse->save();
        }
    }
    if($request->has('specialists')){
        $specialists = explode( ',', $request->specialists );
        foreach ($specialists as $one) {
            $courseSpecialist = new CourseSpecialist();
            $courseSpecialist->course_id = $course->id;
            $courseSpecialist->specialist_id = $one;
            $courseSpecialist->save();
        }
    }
       return response([
           'msg'=>'success',
           'status'=>true,
           'course_id'=>$course->id,
           200
       ]);

       return response([
        'msg'=>'fail',
        'status'=>false,
        201
    ]);

   }

   public function UploadCourseVideo(Request $request)
   {

       $videoCourse = new CourseVideos();

    //    if ($request->hasFile('coverImage')) {
    //     $coverImage = $request->file('coverImage');
    //     $imageName = 'courseCoverImg' . '-' . $coverImage->getClientOriginalName();
    //     $pathImg = $coverImage->storeAs('public/images/videoCoverImgs', $imageName);


    //     }
        if ($request->hasFile('video')) {
            $track = GetId3::fromUploadedFile($request->file('video'));
            $length = $track->getPlaytime();
            $video = $request->file('video');
            $videoName = 'courseVideo' . '-' . $video->getClientOriginalName();
            $pathVid = $video->storeAs('public/videos/courseVideos', $videoName);
            $url = url('/storage/videos/courseVideos/'.$videoName);

        }



        $videoCourse->url= $url !== "" ? $url : '';
        $videoCourse->cover_image = '';
        $videoCourse->course_id= $request->course_id;
        $videoCourse->status= $request->is_publish =='true' ? true : false;
        $videoCourse->description= $request->description;
        $videoCourse->title= $request->title ;
        $videoCourse->length= $length ;
        $videoCourse->save();
        if($videoCourse){
            $courseVideos = CourseVideos::where('course_id',$videoCourse->course_id)->get();

            return response([
                'msg'=>'success',
                'status'=>true,
                'videos'=>$courseVideos,
                200
            ]);
        }
        return response([
         'msg'=>'fail',
         'status'=>false,
         201
     ]);
    }

   public function getCoursesInitData()
   {
        $categories = CourseCategory::all()->where('status',1);
        $specialists = Specialist::all();
        $data = [];
        foreach ($specialists as  $specialist) {
            $specialist->user->toArray();
            $specialist->toArray();
            array_push($data,$specialist);
        }
               if(count($categories) > 0)
        return response()->json([
                'specialists'=>$specialists,
                'categories'=>$categories,
            'status'=>true,
            200
        ]);
        return response([
            'msg'=>'fail',
            'status'=>false,
        ],204);
   }

   public function getAllcourses()
   {
      $courses = Courses::all();
      $data = [];
      foreach ($courses as $course) {
        $data [] =[
            'id'=>$course->id,
            'title'=>$course->courseTitle,
            'providers'=>$course->course_providers,
            'videos_count'=>count($course->videos),
            'course_length'=>$course->course_length,
            'cover_photo'=>$course->cover_photo,
            'is_free'=>$course->is_free,
            'price'=>$course->price,
            'discount'=>[
                'has_discount'=>true,
                'discount_value'=>"50%",
                'discount_price'=>$course->price - $course->price * (50/100),
            ],
            'categories'=>$course->category_name

        ];
      }
    //   dd($data);

       if($courses){
        return response()->json([
            'courses' => $data,
            'status'=>true,
            200
        ]);
       }
   }

   public function getCourseVideos($id)
   {
       try{
        $course = Courses::findOrFail($id);
        return response()->json([
             'msg'=>'success',
             'courseInfo'=>[
                 'title'=>$course->courseTitle,

             ],
             'count'=>$course->videos->count(),
             'videos'=>$course->videos ? $course->videos : [] ,
             'haveVideos'=>$course->videos->count() > 0 ? true : false
        ]);
    } catch (ModelNotFoundException $e){
        return response()->json([
            'msg'=>'faild',
            'status'=>false,
            404

       ]);
    }



   }

   public function getCourseAndVideos($id)
   {
       try{
        $course = Courses::findOrFail($id);
        return response()->json([
             'msg'=>'success',
             'course'=>$course,
             'count'=>$course->videos->count(),
            //  'videos'=>$course->videos ? $course->videos : [] ,
             'haveVideos'=>$course->videos->count() > 0 ? true : false
        ]);
    } catch (ModelNotFoundException $e){
        return response()->json([
            'msg'=>'faild',
            'status'=>false,
            404

       ]);
    }
   }

   public function updateVideo(Request $request, $id)
   {
       try{
        $video = CourseVideos::findOrFail($id);

        // if ($request->hasFile('coverImage')) {
        //     Storage::delete('public/images/videoCoverImgs/'.$video->cover_image);
        //     $coverImage = $request->file('coverImage');
        //     $imageName = 'courseCoverImg' . '-' . $coverImage->getClientOriginalName();
        //     $pathImg = $coverImage->storeAs('public/images/videoCoverImgs', $imageName);

        //     }

            if ($request->hasFile('video')) {
             $track = GetId3::fromUploadedFile($request->file('video'));

                Storage::delete('public/videos/courseVideos/'.$video->url);
                $nVideo = $request->file('video');
                $videoName = 'courseVideo' . '-' . $nVideo->getClientOriginalName();
                $pathVid = $nVideo->storeAs('public/videos/courseVideos', $videoName);
                $url = url('/storage/videos/courseVideos/'.$videoName);
                $video->url= $url ;
            }

            // $video->cover_image = $request->hasFile('coverImage') ? $imageName:$video->cover_image;
            $video->status= $request->is_publish == 1 ? true : false;
            $video->description= $request->description;
            $video->title= $request->title ;
            // $video->url= $url ? $url :$video->url;

            $video->save();
        return response()->json([
             'msg'=>'success',
                200,
                'status'=>true
        ]);
    } catch (ModelNotFoundException $e){
        return response()->json([
            'msg'=>'faild',
            'status'=>false,
            404

       ]);
    }
   }

   public function getCoruseInfo($id)
   {

    try{
        $course = Courses::findOrFail($id);
        return response()->json([
             'msg'=>'success',
             'course'=>$course,
             'coursecat'=>$course->category_name,
             'courseProviders'=>$course->course_providers,
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

   public function updateCoruseInfo(Request $request, $id)
   {
    //    dd($request->specialists);
    try{
        $course = Courses::findOrFail($id);
        if($request->has('category')){
            $oldcourseCat = $course->courseCategories;
            if(count($oldcourseCat) > 0){
                foreach ($oldcourseCat as $one) {
                    # code...
                    $one->delete();
                }
            }
            $categories = explode( ',', $request->category );

            foreach ($categories as $one) {
                $categoryCourse = new CategoryCourse();
                $categoryCourse->course_id = $course->id;
                $categoryCourse->cat_id = $one;
                $categoryCourse->save();
            }
        }
        if($request->has('specialists')){
            $oldspec = $course->courseProvider;
            if(count($oldspec) > 0){
                foreach ($oldspec as $one) {
                    $one->delete();
                }
            }
            $specialists = explode( ',', $request->specialists );
            foreach ($specialists as $one) {
                $courseSpecialist = new CourseSpecialist();
                $courseSpecialist->course_id = $course->id;
                $courseSpecialist->specialist_id = $one;
                $courseSpecialist->save();
            }
        }
        if ($request->hasFile('coverImage')) {
            Storage::delete('public/images/courseCoverImg/'.$course->cover_image);
            // $coverImage = $request->file('coverImage');
            // $imageName = 'courseCoverImg' . '-' . $coverImage->getClientOriginalName();
            // $pathImg = $coverImage->storeAs('public/images/courseCoverImg', $imageName);

            $coverImage = $request->file('coverImage');
            $imageName = 'courseCoverImg' . '-' . $coverImage->getClientOriginalName();
            $pathImg = $coverImage->storeAs('public/images/courseCoverImg', $imageName);

            $coverUrl = url('/storage/images/courseCoverImg/'.$imageName);
            }
            if ($request->hasFile('promoVideo')) {
                Storage::delete('public/videos/promoVideo/'.$course->cover_image);
                $promoVideo = $request->file('promoVideo');
                $videoName = 'coursePromoVideo' . '-' . $promoVideo->getClientOriginalName();
                $pathVid = $promoVideo->storeAs('public/videos/promoVideo', $videoName);
                $promoUrl = url('/storage/videos/promoVideo/'.$videoName);
    }

           $course->courseTitle = $request->title;
           $course->courseDescription= $request->description;
        //    $course->category_id= $request->category;
           $course->whatWeLearn= $request->watWeLearn;
           $course->is_publish= $request->is_publish;
           $course->is_free= $request->is_free;
           $course->price= $request->price;
           $course->promo_video= $request->hasFile('promoVideo') ? $promoUrl :$course->promo_video  ;
           $course->cover_photo = $request->hasFile('coverImage') ? $coverUrl:$course->cover_photo;

           $course->save();

        return response()->json([
             'msg'=>'success',
             'course'=>$course,
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

   public function preview($id, CourseData $courseData)
   {
        $data = $courseData->execute($id);

        return response()->json($data, 200);
   }

    public function deleteCourse($id)
    {
        try {
            $course = Courses::findorfail($id) ;

            // delete course videos
            if(count($course->videos) > 0)
            {
                foreach ($course->videos as $one) {

                    $one->delete();
                }
            }
            // delete course providers
            if(count($course->courseProvider) > 0)
            {
                foreach ($course->courseProvider as $one) {

                    $one->delete();
                }
            }
            // delete course categories
            if(count($course->courseCategories) > 0)
            {
                foreach ($course->courseCategories as $one) {

                    $one->delete();
                }
            }



            // delete course quiz
                // code ..

            //delete course certifcate

            // delete the course
            $course->delete();

            return response()->json(200);

        }catch (ModelNotFoundException $e){
            return response()->json([
                'msg'=>'faild',
                'status'=>false,
                404
        ]);
        }

    }

}
