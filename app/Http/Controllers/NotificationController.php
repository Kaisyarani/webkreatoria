<?php

 namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class NotificationController extends Controller
    {
        /**
         * Menampilkan semua notifikasi pengguna.
         */
        public function index()
        {
            $user = Auth::user();
            $all_notifications = $user->notifications()->paginate(15); // Ambil semua notifikasi dengan paginasi

            return view('notifications.index', compact('all_notifications'));
        }

        /**
         * Menandai semua notifikasi sebagai telah dibaca.
         */
        public function markAllAsRead()
        {
            Auth::user()->unreadNotifications->markAsRead();
            return back()->with('status', 'Semua notifikasi telah ditandai sebagai dibaca.');
        }
    }
