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
        $guard = currentGuard();
        $user  = Auth::guard($guard)->user();

        if (! $user) {
            abort(401, 'Unauthenticated');
        }

        // لو كلمة المرور الحالية غلط
        if (! Hash::check($request->current_password, $user->password)) {
            abort(422, 'Current password is incorrect');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return $user;
    }


    public function updateProfile($request)
    {
        $guard = currentGuard(); // Helper function
        $user  = Auth::guard($guard)->user();

        if (! $user) {
            abort(401, 'Unauthenticated');
        }

        // مسار الصورة حسب guard
        $path = $user->photo;
        if ($request->hasFile('photo')) {
            $path = Storage::putFile($guard, $request->photo);
        }

        $validated = $request->validated();
        $validated['photo'] = $path;

        $user->update($validated);

        return $user;
    }
}
