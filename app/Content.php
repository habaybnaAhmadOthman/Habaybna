<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Content extends Model
{
   protected $table = 'old_content';
   protected $primaryKey = 'nid';
   public $timestamps = false;

   public function FavArticles()
   {
       return $this->HasMany(UsersFavouriteArticles::class,'article_id');
   }

   public function userFavArticle()
   {
    //    dd($this->FavArticles->where('user_id',Auth::id())->first())
    //    return $this->FavArticles->where('user_id',Auth::id())->first() ? ['is_fav'=>true] :['is_fav'=>false];
   }
}
