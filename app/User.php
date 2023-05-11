<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\ParentUsers;
use App\Other;
use App\Specialist;




class User extends Authenticatable
{
    use HasApiTokens, Notifiable  ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone', 'email','phone','otp','is_verify','role','password','country'
    ];
    protected $appends = ['user_data'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // specialist //

    public function specialist()
    {
        return $this->hasOne(Specialist::class,'user_id');
    }
    public function getIsSpecialistAttribute()
    {
        return $this->specialist ? true : false ;
    }

    // parent //

    public function parent()
    {
        return $this->hasOne(ParentUsers::class,'user_id');
    }
    public function getIsParentAttribute()
    {
        return $this->parent ? true : false ;
    }


    // other //

    public function other()
    {
        return $this->hasOne(Other::class,'user_id');
    }
    public function getIsOtherAttribute()
    {
        return $this->other ? true : false ;
    }

    // interests

    public function interests()
    {
        return $this->belongsToMany(CourseCategory::class, 'user_interests','user_id','interest_id');
    }
    public function getUserDataAttribute()
    {
        switch ($this->role) {
            case 'parent':
                return ParentUsers::where('user_id',$this->id)->first();
                break;
            case 'specialist':
                return Specialist::where('user_id',$this->id)->first();
                break;
            case 'other':
                return Other::where('user_id',$this->id)->first();
                break;
            // case 'admin':
            //     return $this;
            //     break;

            default:
                # code...
                break;
        }
    }

    public function getIsVerfiedAttribute()
    {
        return $this->is_verify ? true : false ;
    }

    public function coursePurchaseOrder()
    {
        return $this->hasMany(Coursespurchaseorders::class,'user_id');
    }

    public function getUserCoursesAttribute()
    {
        $courses = [];
        if($this->coursePurchaseOrder && $this->coursePurchaseOrder->count() > 0){
            foreach ($this->coursePurchaseOrder as $one) {

                if($one->status){
                        array_push($courses, $one->course_id);
                }
            }
            return $courses;
        }
    }



    public function userVideoProgress()
    {
        return $this->hasMany(UserCourseProgress::class,'user_id');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Courses','users_favourite_courses','user_id','course_id');

    }

    public function articles()
    {
        return $this->hasMany(UsersFavouriteArticles::class,'user_id');
    }

    public function specialArticles()
    {
        return $this->hasMany(NewContent::class,'id');
    }






}
