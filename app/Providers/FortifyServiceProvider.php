<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Config;
use Laravel\Fortify\Contracts\LoginResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $request = request();
        if ($request->is('admin/*')) {
            Config::set('fortify.prefix', 'admin');
        } elseif ($request->is('instructor/*')) {
            Config::set('fortify.prefix', 'instructor');
        } else {
            Config::set('fortify.prefix', '');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Fortify::authenticateUsing(function (Request $request) {
            if ($request->is('admin/*')) {
                $guard = 'admin';
            } elseif ($request->is('instructor/*')) {
                $guard = 'instructor';
            } else {
                $guard = 'web';
            }

            if (Auth::guard($guard)->attempt(
                $request->only('email', 'password'),
                $request->boolean('remember')
            )) {
                return Auth::guard($guard)->user();
            }

            return null;
        });

        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    if (auth('admin')->check()) {
                        return redirect()->intended(route('admin.dashboard'));
                    }

                    if (auth('instructor')->check()) {
                        return redirect()->intended(route('instructor.dashboard'));
                    }

                    // user (web)
                    return redirect()->intended('/');
                }
            };
        });






        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

       Fortify::loginView(function (Request $request) {

    if ($request->is('admin/*')) {
        return view('backend.admin.login.index');
    }

    if ($request->is('instructor/*')) {
        return view('backend.instructor.login.index');
    }

    return view('auth.login'); // web
});

Fortify::registerView(function (Request $request) { 
    return view('auth.register');
});
        
    }
}
