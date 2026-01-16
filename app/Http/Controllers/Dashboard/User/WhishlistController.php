<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\Whishlist;
use App\Services\WhishlistService;
use Illuminate\Http\Request;

class WhishlistController extends Controller
{


    public function addToWhishlist(Request $request, WhishlistService $whishlistService)
    {
        try {

            if (!auth('web')->user()) {

                return response()->json([
                    'status' => 'error',
                    'message' => "Please login first",
                ], 401);
            }


            if ($whishlistService->checkWhishlist(auth('web')->user()->id, $request->course_id)) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Course already added to wishlist",
                ], 400);
            }

            $whishlistService->addToWhishlist($request);
            return response()->json([
                'status' => 'success',
                'message' => "Wishlist added successfully",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Something went wrong " . $e->getMessage(),
            ], 500);
        }
    }


    public function allWhishlist(WhishlistService $whishlistService)
    {
        try {

            $userId = auth('web')->id();

            $wishlistItems = $whishlistService->getWhishlist($userId);

            $html = view(
                'frontend.pages.home.partials.wishlist',
                compact('wishlistItems')
            )->render();

            return response()->json([
                'status' => 'success',
                'html'   => $html,
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong' . $e->getMessage(),
            ], 500);
        }
    }


    public function index()
    {
        try {
            $user_id = auth('web')->user()->id;
            return view('backend.user.wishlist.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong ' . $e->getMessage());
        }
    }

    public function getWishlist()
    {
        try {
            if (!auth('web')->check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            $userId = auth('web')->id();

            $wishlist = Whishlist::where('user_id', $userId)
                ->with('course', 'course.instructor')
                ->paginate(6);

            return response()->json([
                'status'   => 'success',
                'wishlist' => $wishlist
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function destroy($id, WhishlistService $whishlistService)
    {
        try {
            $wishlist = Whishlist::findOrFail($id);
            if ($wishlist) {
                $whishlistService->deleteWhishlist($id);
                $wishlistCount = Whishlist::where('user_id', auth('web')->id())->count();
                return response()->json([
                    'status' => 'success',
                    'message' => "Wishlist deleted successfully",
                    'wishlist_count' => $wishlistCount,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Something went wrong " . $e->getMessage(),
            ], 500);
        }
    }
}
