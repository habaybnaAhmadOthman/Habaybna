<?php

// ahmad al othman
// 16-9-2021
// habaybna.net

namespace App\Http\Controllers;
use App\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;




class CoursesCategoriesController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::all();
        return view('admin.couresesCategories.index',['categories'=>$categories]);
    }

    public function create()
    {
        return view('admin.couresesCategories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:course_categories|max:255',

        ]);

        $category = new CourseCategory();

        $category->title = $request->title ;
        $category->status = 1 ;

        $category->save();

        return redirect()->route('coursesCategories')
        ->with('success',"Category Added scuccessfully");


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

        return redirect()->route('coursesCategories')
        ->with('success',"Category updated scuccessfully");

    }
}
