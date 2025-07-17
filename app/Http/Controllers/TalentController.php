<?php

namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\View\View;

    class TalentController extends Controller
    {
        /**
         * Display a listing of the talents.
         */
        public function index(): View
        {
            // Ambil semua user dengan tipe akun 'kreator'
            // dan muat relasi profil mereka untuk efisiensi
            $talents = User::where('account_type', 'kreator')
                            ->with('kreatorProfile')
                            ->get();

            // Kirim data talenta ke view
            return view('explore.index', compact('talents'));
        }

        public function aiAssistant(): View
        {
        // Cukup tampilkan view-nya
        return view('explore.ai-assistant');
        }
    }

