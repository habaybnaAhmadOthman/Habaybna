<?php

namespace app\CustomClass;

use App\User;
use phpDocumentor\Reflection\Types\Object_ as TypesObject_;
use PhpParser\Node\Expr\Cast\Object_;

class GetAllUsers {

    public function execute()
    {
        try{

            $users = User::where('role', '!=', 'admin')->get();
            $users_data = [] ;
            foreach($users as $user){
                if($user->user_data){
                   $users_data[] = [
                    'user_id'=>$user->id ,
                    'user_name'=>$user->user_data->firstName.' '.$user->user_data->lastName ,
                   ];
                }
            }
            return $users_data;
        }catch (\Throwable $th) {
            throw $th;
        }
    }

}
