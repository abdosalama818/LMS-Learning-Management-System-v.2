<?php

namespace App\Repository;

use App\Interface\ProfileInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileRepository implements ProfileInterface
{
    public function resetPassword($request)
    {
        if(Auth::guard('admin')->check()){
            $user = Auth::guard('admin')->user();
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
        }elseif(Auth::guard('instructor')->check()){
            $user = Auth::guard('instructor')->user();
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
        }    
        return $user;
    }

    public function updateProfile($request)
    {

        $user = Auth::guard('instructor')->user();
        if ($user) {
            $path = $user->photo;
            if ($request->hasFile('photo')) {
                $path = Storage::putFile('instructor', $request->photo);
            }

            $validated = $request->validated();
            $validated['photo'] = $path;
            $user->update($validated);
        }elseif($user = Auth::guard('admin')->user()){
            $path = $user->photo;
            if($request->hasFile('photo')){
                $path = Storage::putFile('admin', $request->photo);  
            }

            $validated = $request->validated();
            $validated['photo'] = $path;
            $user->update($validated);

        } 
        return $user;
    }
}
