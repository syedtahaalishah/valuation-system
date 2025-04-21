<?php

namespace App\Providers;

use App\Models\User;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!request()->is('admin/*')) {
            Fortify::authenticateUsing(function ($request) {
                $user = User::where('email', $request->email)->first();

                if ($user && Hash::check($request->password, $user->password)) {
                    if (!$user->status) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'email' => ['Your account is deactivated by the admin.'],
                        ]);
                    }
                    return $user;
                }
            });
        }
    }
}
