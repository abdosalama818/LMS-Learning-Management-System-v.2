<?php

namespace App\Services;

use App\Repository\ApplyCouponRepository;


class ApplyCouponService
{
    public $applycouponRepository;
    public function __construct(ApplyCouponRepository $applycouponRepository)
    {
        $this->applycouponRepository = $applycouponRepository ;
    }


    public function applyCoupon($couponName,$courseIds,$instructorIds){

        return $this->applycouponRepository->applyCoupon($couponName,$courseIds,$instructorIds);
        
    }
 

}