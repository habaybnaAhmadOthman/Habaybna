<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::all();

        return response($media,200);
    }
    public function create(Request $request)
    {
        $media = new Media();

        $media->title = $request->title ;
        $media->url = $request->url ;
        // $media->status = $request->status ;

        $media->save();

        if ($request->hasFile('coverImage')) {
            $coverImage = $request->file('coverImage');
            $imageName = 'mediaCoverImg' . '-' . $coverImage->getClientOriginalName();
            $pathImg = $coverImage->storeAs('public/images/mediaCoverImg', $imageName);

            $coverUrl = url('/storage/images/mediaCoverImg/'.$imageName);
            $media->image = $coverUrl ? $coverUrl: '';

            $media->save();

            return response('added',200);
        }

    }
}
