<?php

namespace App\Services;

use App\Repository\ApplyCouponRepository;
use App\Repository\CouponRepository;

class CouponService
{
    public $couponRepository;
    public $applyCouponRepository ;
    public function __construct(CouponRepository $couponRepository , ApplyCouponRepository $applyCouponRepository)
    {
        $this->couponRepository = $couponRepository ;
        $this->applyCouponRepository = $applyCouponRepository ;
    }
    public function storeCoupon($data){

        $data['instructor_id'] = auth('instructor')->user()->id;
        $this->couponRepository->store($data);
    }

    public function updateCoupon($id,$data){

      $data['instructor_id'] = auth('instructor')->user()->id;
     $this->couponRepository->updateCoupon($id,$data);

    }

    public function deleteCoupon($data){
        return $this->couponRepository->deleteCoupon($data);
    }

}