<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\IsParent;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Child;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;




class ChildController extends Controller
{
    public $parent ;
    public function __construct()
    {
        $this->middleware(['auth', 'parent']);

    }
    public function index()
    {
        $childs = Auth::user()->children()->where('status',1)->orderByDesc('id')->get() ;
        return response($childs, 200);
    }

    public function store(Request $request)
    {
        // json_decode($parent->children()->find(3)->interests)  ;

        $parent =Auth::user();
        if($parent->children->count() >= 5){
            return response("failed",201);
        }

        $child = $parent->children()->create([
            'name'=>$request->name,
            'dob'=>$request->dob,
            'gender'=>Str::lower($request->gender),
            'other_info'=>$request->other_info,
            'interests'=>$request->selectedIntersests
        ]);
        if($request->hasFile('photo')) {
            $imageName = 'child'.$child->id . '-' .$request->file('photo')->getClientOriginalName();

            $request->file('photo')->storeAs('public/images/childs', $imageName);
            $path= url('/storage/images/childs/'.$imageName);
            $child->photo = $path;
            $child->save();
        }
                $chidls = DB::table('users')
                                ->join('children','users.id','=','children.user_id')
                                ->where('users.id',Auth::id())
                                ->select('children.*')
                                ->get();
        return response($chidls, 200);



    }

    public function edit(Request $request)
    {
        $parent =Auth::user();

        $childUpdate = $parent->children()->where('id',$request->id)->update([
            'name'=>$request->name,
            'dob'=>$request->dob,
            'gender'=>Str::lower($request->gender),
            'other_info'=>$request->other_info,
            'interests'=>$request->interests
        ]);

        if($childUpdate && $request->hasFile('photo')) {
            $child = $parent->children()->where('id',$request->id)->first();
            Storage::delete($child->photo);
            $imageName = 'child'.$child->id . '-' .$request->file('photo')->getClientOriginalName();

            $request->file('photo')->storeAs('public/images/childs', $imageName);
            $path= url('/storage/images/childs/'.$imageName);
            $child->photo = $path;
            $child->save();
        }
        return response($parent->children, 200);
    }

    public function delete(Request $request)
    {
        $parent =Auth::user();
        $child = $parent->children()->where('id',$request->id)->first();
        Storage::delete($child->photo);
        $child->delete();


        return response($parent->children, 200);
    }


}
