<?php

namespace App\Http\Controllers\Dashboard\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyCouponRequest;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Services\ApplyCouponService;
use App\Services\CouponService;
use Illuminate\Http\Request;
use SebastianBergmann\Type\TrueType;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_coupon = Coupon::where('instructor_id', '=' , auth('instructor')->user()->id)->get();
        return view('backend.instructor.coupon.index', compact('all_coupon'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.instructor.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponRequest $request , CouponService $couponService)
    {
        $data = $request->validated();
        try{
            $couponService->storeCoupon($data);
            return redirect()->route('instructor.coupon.index')->with('success', 'Coupon created successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

//applyCheckoutCoupon
public function applyCheckoutCoupon(ApplyCouponRequest $request, ApplyCouponService $couponService)
{
    $validated = $request->validated();
    $couponName = $validated['coupon'];
    $courseIds = $validated['course_id'];
    $instructorIds = $validated['instructor_id'];

    $discounts = $couponService->applyCoupon($couponName, $courseIds, $instructorIds);

    $totalDiscount = collect($discounts)->sum('discount'); 
    Session(['coupon' => $totalDiscount]);

    return redirect()->back()->with('success', 'Coupon applied successfully');
}



public function applyCoupon(ApplyCouponRequest $request, ApplyCouponService $couponService)
{
    $validated = $request->validated();
    $couponName = $validated['coupon'];
    $courseIds = $validated['course_id'];
    $instructorIds = $validated['instructor_id'];


    $discounts = $couponService->applyCoupon($couponName, $courseIds, $instructorIds);

    $totalDiscount = collect($discounts)->sum('discount'); 
    Session(['coupon' => $totalDiscount]);

    return response()->json([
        'status' => count($discounts) ? 'success' : 'error',
        'message' => count($discounts) ? 'Coupon applied successfully' : 'No valid coupon found for this course',
        'discounts' => $discounts 
    ]);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
      $coupon = Coupon::where('id',$id)->where('instructor_id',auth('instructor')->user()->id)->first();
      return view('backend.instructor.coupon.edit',compact('coupon'));

        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponService $couponService ,CouponRequest $request, string $id)
    {
        $data = $request->validated();
      
        try{
            $couponService->updateCoupon($id,$data);
            return redirect()->route('instructor.coupon.index')->with('success', 'Coupon updated successfully');

        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CouponService $couponService , $id )
    {
        try{
            $data = Coupon::where('id',$id)->where('instructor_id',auth('instructor')->user()->id)->first();
            $couponService->deleteCoupon($data);
            return redirect()->route('instructor.coupon.index')->with('success', 'Coupon deleted successfully');

        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
