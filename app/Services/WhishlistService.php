<?php

namespace App\Services;

use App\Models\Whishlist;
use App\Repository\WhishlistRepository;


class WhishlistService
{

    public $whishlistRepository;
    public function __construct(WhishlistRepository $whishlistRepository)
    {
        $this->whishlistRepository = $whishlistRepository;
    }
   

    
    public function addToWhishlist($request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        if (!auth('web')->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please login first'
            ], 401);
        }

        $user_id = auth('web')->id();


        $this->whishlistRepository->addToWhishlist([
            'user_id'   => $user_id,
            'course_id'=> $data['course_id'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Wishlist added successfully',
            'wishlist_count' => $this->countByUser($user_id),
            'wishlist_course' => $this->getWhishlist($user_id),
        ]);
    }



    public function getWhishlist($user_id)
    {
        return Whishlist::where('user_id', $user_id)->with('course', 'course.instructor')->get();
    }



    public function deleteWhishlist($id)
    {
        return $this->whishlistRepository->deleteWhishlist($id);
    }

    public function checkWhishlist($user_id, $course_id)
    {
        return $this->whishlistRepository->checkWhishlist($user_id, $course_id);
    }

    public function countByUser($user_id)
{
    return Whishlist::where('user_id', $user_id)->count();
}


}
