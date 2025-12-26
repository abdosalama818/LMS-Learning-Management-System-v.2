<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

        public $profileService;
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    
    public function index()
    {
        return view('backend.admin.dashboard.index');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }




    public function profile()
    {

        return view('backend.admin.profile.index');
    }

    public function setting()
    {

        return view('backend.admin.profile.setting');
    }

    public function resetPassword(Request $request)
    {

        try {

            $this->profileService->resetPassword($request);
            return redirect()->back()->with('success', 'Password updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateProfile(ProfileRequest $request)
    {
        try {
            $this->profileService->updateProfile($request);
            return redirect()->back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
