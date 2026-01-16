<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GoogleRequest;
use App\Http\Requests\StripRequest;
use App\Models\Google;
use App\Models\Stripe;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function stripSetting()
    {
        $stripeSettings = Stripe::first();
        return view('backend.admin.setting.stripe.index', compact('stripeSettings'));
    }

    public function stripSettingUpdate(StripRequest $request)
    {
        try { 
            $data = $request->validated();
            $stripeSettings = Stripe::first();
            if($stripeSettings){
                $stripeSettings->update($data);
            }else{
                Stripe::create($data);
            }
            return redirect()->back()->with('success', 'Stripe settings updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }   
    }


      public function googleSetting()
    {
        $google = Google::first();
        return view('backend.admin.setting.google.index', compact('google'));
    }

    public function updateGoogleSettings(GoogleRequest $request)
    {
        try{
            $data = $request->validated();
            $google = Google::first();
            if($google){
                $google->update($data);
            }else{
                Google::create($data);
            }
          return redirect()->back()->with('success', 'Google updated successfully!');


       } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }  


    }
}
