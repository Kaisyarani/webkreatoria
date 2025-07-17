<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         View::composer('layouts.navigation', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $notifications = $user->unreadNotifications->take(5);
                $view->with('notifications', $notifications);
        }
    });
}
}
