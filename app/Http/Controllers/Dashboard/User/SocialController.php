<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{

    public function googleLogin()
    {
   //   return  session()->get("a3");
        try{
           return Socialite::driver('google')->redirect();

        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong!'  . $e->getMessage());

        }
     
    }

    public function googleAuthentication()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
          

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'email' => $googleUser->email,
                    'name' => $googleUser->name,
                    'photo' => $googleUser->avatar,
                    'password' => Hash::make(uniqid()),
                ]);
            }

            Auth::guard('web')->login($user);

            return redirect()->route('user.dashboard');
        } catch (\Exception $e) {
                        session()->put('a3', '' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!' . $e->getMessage());
        }
    }
}
