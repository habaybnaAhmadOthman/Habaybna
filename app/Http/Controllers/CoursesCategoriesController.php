<?php

// ahmad al othman
// 16-9-2021
// habaybna.net

namespace App\Http\Controllers;
use App\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CategoryCourse;




class CoursesCategoriesController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::orderBy('id','desc')->paginate(10);

        return response($categories, 200);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:course_categories|max:255',

        ]);

        $category = new CourseCategory();

        $category->title = $request->title ;
        $category->status = $request->status ;

        $category->save();

        return response($category, 200);


    }

    public function edit($id)
    {
        $category = CourseCategory::findorfail($id);

        return view('admin.couresesCategories.edit',['category'=>$category]);

    }

    public function update(Request $request, $id)
    {
        $category = CourseCategory::findorfail($id);

        $category->title = $request->title ;
        $category->status = $request->status ;

        $category->save();

        return response($category,200);

    }

    public function delete(Request $request , $id)
    {
        if(CategoryCourse::where('cat_id',$id)->count() > 0) {
            foreach(CategoryCourse::where('cat_id',$id)->get() as $one){
                $one->delete();
            }
        }

        $category = CourseCategory::findorfail($id);

        $category->delete();
    }
}
