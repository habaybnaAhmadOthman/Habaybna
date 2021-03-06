<?php

namespace app\CustomClass;

use App\Content;
use App\NewContent;
use App\ArticlesTags;
use Illuminate\Support\Facades\Storage;



class UpdateContent {

    public function execute(array $data)
    {
        try {

            $content = NewContent::findorfail($data['id']);
            // dd($content);
            $content->title = $data['title'] ;
            $content->status = $data['status'] ;
            $content->content = $data['content'] ;
            $content->author_id = $data['author'];
            $content->created_at = $data['publishDate'];
            $content->slug = $this->slug($data['title'],'-');

            $content->save();
            $x =  ArticlesTags::where('article_id',$content->id)->get();

                    foreach ($x as $key ) {
                        $key->delete();
                    }
                    
                foreach (explode(',', $data['categories']) as $key) {
                    // dd($content->intrests);
                    ArticlesTags::create([
                        'tag_id'=>$key,
                        'article_id'=>$content->id,
                    ]);
                }

                if (gettype($data['image']) == 'object') {
                    // Storage::delete($media->url);
                    $coverImage = $data['image'];
                    $imageName = 'contentCoverImg' . '-' . $coverImage->getClientOriginalName();
                    $pathImg = $coverImage->storeAs('public/images/contentCoverImg', $imageName);

                    $coverUrl = url('/storage/images/contentCoverImg/'.$imageName);
                    $content->cover_photo = $coverUrl ? $coverUrl: '';

                    $content->save();

                }else{
                    $content->cover_photo = $data['image'];
                }

                return $content;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function slug($string, $separator = '-') {
        if (is_null($string)) {
            return "";
        }
        $string = trim($string);

        $string = mb_strtolower($string, "UTF-8");;

        $string = preg_replace("/[^a-z0-9_\s????????????????????????????????????????????????????????????????????????]#u/", "", $string);

        $string = preg_replace("/[\s-]+/", " ", $string);

        $string = preg_replace("/[\s_]/", $separator, $string);

        return $string;
    }

}
