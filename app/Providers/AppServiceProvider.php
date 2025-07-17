<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Import View
use Illuminate\Support\Facades\Auth; // Import Auth
use App\Models\Post; // Import model Post
use App\Policies\PostPolicy; // Import PostPolicy

class AppServiceProvider extends ServiceProvider

{

    protected $policies = [
        Post::class => PostPolicy::class, // Tambahkan baris ini
    ];
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
        // Bagikan data notifikasi ke view layouts.navigation
        View::composer('layouts.navigation', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                // Ambil 5 notifikasi terbaru yang belum dibaca
                $notifications = $user->unreadNotifications->take(5);
                $view->with('notifications', $notifications);
            } else {
                // Jika tidak ada yang login, kirim koleksi kosong
                $view->with('notifications', collect());
            }
        });
    }
}
