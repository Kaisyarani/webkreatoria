<?php

namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\User;

    class ChatController extends Controller
    {
        /**
         * Menampilkan halaman chat utama.
         */
        public function index()
        {
            return view('chat');
        }

        /**
         * Memulai atau membuka chat dengan pengguna tertentu.
         */
        public function chatWith(User $user)
        {
            // Kirim data pengguna yang akan diajak chat ke view
            return view('chat', ['chatWithUser' => $user]);
        }
    }
