<?php

namespace App\Services;

use App\Interface\ProfileInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService  
{
    public $profileRepository;

    public function __construct(ProfileInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function resetPassword($request)
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


        }elseif(Auth::guard('instructor')->check()){
            $user = Auth::guard('instructor')->user();
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'The current password does not match our records.',
                ]);
            }    
        }
        return $this->profileRepository->resetPassword($request);
    }


    public function updateProfile($request)
    {
       

        return $this->profileRepository->updateProfile($request);
    }
}
