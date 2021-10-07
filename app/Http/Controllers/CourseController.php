<?php

namespace App\Http\Controllers;
use App\Courses;
use App\CourseCategory;
use App\CourseVideos;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
   public function index(Request $request)
   {
            $courses = Courses::select('id','courseTitle', 'category_id', 'price', 'is_publish', 'is_free')->get();

            return response()->json([
                'courses' => $courses,
                'status'=>true,
                200
            ]);
   }

   public function create()
   {
    //    return view ('admin.courses.create',['categories'=>$categories]);
   }

   public function storeCourseInfo(Request $request)
   {
       $course = new Courses();

       if ($request->hasFile('coverImage')) {
        $coverImage = $request->file('coverImage');
        $imageName = 'courseCoverImg' . '-' . $coverImage->getClientOriginalName();
        $pathImg = $coverImage->storeAs('public/images/courseCoverImg', $imageName);

        }
        if ($request->hasFile('promoVideo')) {
            $promoVideo = $request->file('promoVideo');
            $videoName = 'coursePromoVideo' . '-' . $promoVideo->getClientOriginalName();
            $pathVid = $promoVideo->storeAs('public/videos/promoVideo', $videoName);
        }

       $course->courseTitle = $request->title;
       $course->courseDescription= $request->description;
       $course->category_id= $request->category;
       $course->whatWeLearn= $request->watWeLearn;
       $course->is_publish= $request->is_publish;
       $course->is_free= $request->is_free;
       $course->price= $request->price;
       $course->promo_video= $request->hasFile('promoVideo') ? $videoName : '';
       $course->cover_photo = $request->hasFile('coverImage') ? $imageName: '';

       if($course->save())
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

       if ($request->hasFile('coverImage')) {
        $coverImage = $request->file('coverImage');
        $imageName = 'courseCoverImg' . '-' . $coverImage->getClientOriginalName();
        $pathImg = $coverImage->storeAs('public/images/videoCoverImgs', $imageName);

        }
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = 'courseVideo' . '-' . $video->getClientOriginalName();
            $pathVid = $video->storeAs('public/videos/courseVideos', $videoName);
        }

        $videoCourse->url= $request->hasFile('video') ? $videoName : '';
        $videoCourse->cover_image = $request->hasFile('coverImage') ? $imageName: '';
        $videoCourse->course_id= $request->course_id;
        $videoCourse->status= $request->is_publish;
        $videoCourse->description= $request->description;
        $videoCourse->title= $request->title ;
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

   public function getCoursesCategories()
   {
        $categories = CourseCategory::all()->where('status',1);
        return response()->json([
            'categories' => $categories,
            'status'=>true,
            200
        ]);
   }

   public function getAllcourses()
   {
      $courses = Courses::with('videos')->get();
       if($courses){
        return response()->json([
            'courses' => $courses,
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

        if ($request->hasFile('coverImage')) {
            Storage::delete('public/images/videoCoverImgs/'.$video->cover_image);
            $coverImage = $request->file('coverImage');
            $imageName = 'courseCoverImg' . '-' . $coverImage->getClientOriginalName();
            $pathImg = $coverImage->storeAs('public/images/videoCoverImgs', $imageName);

            }
            if ($request->hasFile('video')) {
                Storage::delete('public/videos/courseVideos/'.$video->url);
                $nVideo = $request->file('video');
                $videoName = 'courseVideo' . '-' . $nVideo->getClientOriginalName();
                $pathVid = $nVideo->storeAs('public/videos/courseVideos', $videoName);
            }

            $video->url= $request->hasFile('video') ? $videoName :$video->url;
            $video->cover_image = $request->hasFile('coverImage') ? $imageName:$video->cover_image;
            $video->status= $request->is_publish;
            $video->description= $request->description;
            $video->title= $request->title ;
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
}
