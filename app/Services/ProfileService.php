<?php

namespace App\Services;

use App\Interface\ProfileInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class ProfileService  
{
    public $profileRepository;

    public function __construct(ProfileInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }


      public function resetPassword($request): void
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|confirmed',
        ]);

        $guard = currentGuard(); // Helpers function to return guard
        $user  = Auth::guard($guard)->user();

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'The current password does not match our records.',
            ]);
        }

        $this->profileRepository->resetPassword($request);
    }

    public function updateProfile($request): void
    {
        $this->profileRepository->updateProfile($request);
    }



 /*    public function resetPassword($request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);
        if(Auth::guard('admin')->check()){
            
            $user = Auth::guard('admin')->user();
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'The current password does not match our records.',
                ]);
            }


        }if(Auth::guard('instructor')->check()){
            $user = Auth::guard('instructor')->user();
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'The current password does not match our records.',
                ]);
            }    
        }
        if(Auth::guard('web')->check()){
             $user = Auth::guard('web')->user();
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'The current password does not match our records.',
                ]);
            }    
        }
        return $this->profileRepository->resetPassword($request);
    } */


   /*  public function updateProfile($request)
    {
       

        return $this->profileRepository->updateProfile($request);
    } */
}
