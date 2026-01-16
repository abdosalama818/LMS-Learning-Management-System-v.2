<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('coupon');
        return [
              'coupon_name' =>"required|string|min:3|unique:coupons,coupon_name,".$id,
            'coupon_discount'=>'required|numeric',
            'coupon_validity' => 'required|date|after_or_equal:today',
            'status'=> "nullable|in:0,1"
        ];
    }
}
