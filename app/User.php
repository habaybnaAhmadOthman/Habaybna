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
        'phone', 'email','phone','otp','is_verify','role'
    ];

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
            case 'admin':
                return $this;
                break;

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
                    $courses[] = [
                       'id'=> $one->id,
                    ];
                }
            }
        }
    }
}
