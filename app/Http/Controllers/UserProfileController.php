<?php

namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\View\View;

    class UserProfileController extends Controller
    {
        /**
         * Display the specified user's public profile.
         */
        public function show(User $user): View
        {
            // Eager load relasi yang dibutuhkan untuk efisiensi
            $user->load('posts');

        // Tentukan view mana yang akan ditampilkan berdasarkan tipe akun
        if ($user->account_type === 'kreator') {
            $profile = $user->kreatorProfile()->firstOrCreate([]);

            return view('profile.profile-kreator', [
                'user' => $user,
                'profile' => $profile, // Variabel $profile dijamin tidak akan null
            ]);
        }

        if ($user->account_type === 'perusahaan') {
            // Lakukan hal yang sama untuk profil perusahaan
            $profile = $user->perusahaanProfile()->firstOrCreate([]);

            return view('profile.profile-perusahaan', [
                'user' => $user,
                'profile' => $profile,
            ]);
        }

        // Fallback jika ada tipe akun lain atau error
        abort(404);
        }
    }
