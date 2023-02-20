<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Partner;
use Illuminate\Support\Facades\Storage;


class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::all();

        return response($partners,200);
    }
    public function create(Request $request)
    {
        $media = new Partner();

        $media->title = $request->title ;
        $media->status = $request->status ;
        // $media->status = $request->status ;

        $media->save();

        if ($request->hasFile('coverImage')) {
            $coverImage = $request->file('coverImage');
            $imageName = 'partnerCoverImg' . '-' . $coverImage->getClientOriginalName();
            $pathImg = $coverImage->storeAs('public/images/partners', $imageName);

            $coverUrl = url('/storage/images/partners/'.$imageName);
            $media->image = $coverUrl ? $coverUrl: '';

            $media->save();

            return response('added',200);
        }

    }

    public function update($id)
    {
        $media =  Partner::findorfail($id);

        // $media->title = $request->title ;
        // $media->url = $request->url ;
        // // $media->status = $request->status ;

        // $media->save();

        // if ($request->hasFile('coverImage')) {
        //     Storage::delete($media->url);

        //     $coverImage = $request->file('coverImage');
        //     $imageName = 'mediaCoverImg' . '-' . $coverImage->getClientOriginalName();
        //     $pathImg = $coverImage->storeAs('public/images/mediaCoverImg', $imageName);

        //     $coverUrl = url('/storage/images/mediaCoverImg/'.$imageName);
        //     $media->image = $coverUrl ? $coverUrl: '';

        //     $media->save();

            return response($media);


    }
    public function edit(Request $request)
    {
        $media =  Partner::findorfail($request->id);

        $media->title = $request->title ;
        // $media->url = $request->url ;
        // $media->status = $request->status ;
        $media->status = $request->status;

        $media->save();

        if ($request->hasFile('coverImage')) {
            Storage::delete($media->url);

            $coverImage = $request->file('coverImage');
            $imageName = 'partnerImg' . '-' . $coverImage->getClientOriginalName();
            $pathImg = $coverImage->storeAs('public/images/partners', $imageName);

            $coverUrl = url('/storage/images/partners/'.$imageName);
            $media->image = $coverUrl ? $coverUrl: '';

            $media->save();

            return response($media);
        }
        return response($media);


    }

    public function getPartners()
    {
        $partners =
        //  Partner::where('status',1)
        //             ->and('image','!=',"")
        //             ->get();

                    Partner::where([
                        ['status','=','1'],
                        ['image','!=','']
                    ])->get();

                    return response($partners, 200);


    }

    public function delete($id)
    {
        $mediaCover = Partner::findorfail($id);

        $mediaCover->delete();

        return response('deleted',200);

    }
}
