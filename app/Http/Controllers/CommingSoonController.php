<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CommingSoon;
use Illuminate\Support\Facades\Storage;


class CommingSoonController extends Controller
{
    public function index()
    {
        $data = CommingSoon::paginate(10);
        return response($data, 200);
    }

    public function store(Request $request)
    {
        $commingsoon = new CommingSoon();

        $commingsoon->order = $request->order ;
        $commingsoon->status = $request->status ;
        // $commingsoon->status = $request->status ;

        $commingsoon->save();

        if ($request->hasFile('coverImage')) {
            $coverImage = $request->file('coverImage');
            $imageName = 'partnerCoverImg' . '-' . $coverImage->getClientOriginalName();
            $pathImg = $coverImage->storeAs('public/images/commingsoon', $imageName);

            $coverUrl = url('/storage/images/commingsoon/'.$imageName);
            $commingsoon->path = $coverUrl ? $coverUrl: '';

            $commingsoon->save();

            return response('added',200);
        }

    }

    public function show(Request $request , $id)
    {
        $comming = CommingSoon::findorfail($id);


        return $comming;
    }

    public function update(Request $request)
    {
        $comming = CommingSoon::findorfail($request->id);

        $comming->order = $request->order ;
        $comming->status = $request->status ;

        $comming->save();

        if ($request->hasFile('coverImage')) {


            $coverImage = $request->file('coverImage');
            $imageName = 'partnerCoverImg' . '-' . $coverImage->getClientOriginalName();
            $pathImg = $coverImage->storeAs('public/images/commingsoon', $imageName);

            $coverUrl = url('/storage/images/commingsoon/'.$imageName);
            $comming->path = $coverUrl ? $coverUrl: '';

            $comming->save();

        }
        return response($comming,200);

    }

    public function getCommingCourses()
    {
        $commingCourses = CommingSoon::where('status',1)->orderBy('order')->limit(10)->get();

        return response($commingCourses, 200);
    }



}
