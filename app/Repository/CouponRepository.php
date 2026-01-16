<?php

namespace App\Repository;

use App\Models\Coupon;

class CouponRepository
{
    public function store($data)
    {
       return Coupon::create($data);
    }

    public function deleteCoupon($data){

        return $data->delete();
    }

    public function updateCoupon($id,$data){
      $coupon = Coupon::where('id',$id)->where('instructor_id',auth('instructor')->user()->id)->first();
      return $coupon->update($data);
    }
}
