<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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

    public function update($id)
    {
        $media =  Media::findorfail($id);

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
        $media =  Media::findorfail($request->id);

        $media->title = $request->title ;
        $media->url = $request->url ;
        // $media->status = $request->status ;

        $media->save();

        if ($request->hasFile('coverImage')) {
            Storage::delete($media->url);

            $coverImage = $request->file('coverImage');
            $imageName = 'mediaCoverImg' . '-' . $coverImage->getClientOriginalName();
            $pathImg = $coverImage->storeAs('public/images/mediaCoverImg', $imageName);

            $coverUrl = url('/storage/images/mediaCoverImg/'.$imageName);
            $media->image = $coverUrl ? $coverUrl: '';

            $media->save();

            return response($media);
        }


    }

    public function delete($id)
    {
        $mediaCover = Media::findorfail($id);

        $mediaCover->delete();

        return response('deleted',200);

    }
}
