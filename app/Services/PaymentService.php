<?php

namespace App\Services;

use App\Repository\StripeRepository;


class PaymentService
{
    public $stripeRepository;
    public function __construct(StripeRepository $stripeRepository)
    {
        $this->stripeRepository = $stripeRepository ;
    }

    public function processPayment($stripeData)
    {
        switch ($stripeData['payment_type']) {
            case 'stripe':
                return $this->stripeRepository->handlePayment($stripeData);
           case 'paybal':
                return 'paybal repo';
            default:
              throw new \Exception('Invalid payment type');    
        }

   }


 

}