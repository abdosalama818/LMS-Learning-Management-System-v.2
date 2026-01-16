<?php

namespace App\Repository;

use App\Models\Whishlist;

class WhishlistRepository 
{
   public function addToWhishlist($data){
    return Whishlist::create($data);
   }
   
   public function getWhishlist($user_id){
    return Whishlist::where('user_id', $user_id)->get();
   }

   public function checkWhishlist($user_id,$course_id){
    return Whishlist::where('user_id', $user_id)->where('course_id', $course_id)->first();
   }

   public function deleteWhishlist($id){
    return Whishlist::destroy($id);
   }


   

   
}