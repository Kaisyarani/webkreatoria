<?php

namespace App\Http\Controllers;

    use App\Models\Job;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class JobController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            // Ambil semua data lowongan, beserta data user (perusahaan) yang memposting
            $jobs = Job::with('user')->latest()->get();

            // Periksa apakah pengguna sudah login
            if (Auth::check()) {
                // Jika sudah login, periksa perannya
                if (Auth::user()->account_type == 'kreator') {
                    return view('Jobs.kreator', ['jobs' => $jobs]);
                } elseif (Auth::user()->account_type == 'perusahaan') {
                    return view('Jobs.perusahaan', ['jobs' => $jobs]);
                }
            }

            // Jika tidak login (tamu), tampilkan view default
            return view('jobs.guest', ['jobs' => $jobs]);
        }

        public function create()
    {
        // Pastikan hanya perusahaan yang bisa mengakses halaman ini
        if (Auth::user()->account_type !== 'perusahaan') {
            abort(403, 'Akses Ditolak.');
        }

        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Pastikan hanya perusahaan yang bisa menyimpan lowongan
        if (Auth::user()->account_type !== 'perusahaan') {
            abort(403, 'Akses Ditolak.');
        }

        // 1. Validasi semua input dari form
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'required|string',
            'tags' => 'required|string', // Tags diterima sebagai string
            'deadline' => 'required|date',
        ]);

        // 2. Proses data sebelum disimpan
        $tagsArray = array_map('trim', explode(',', $validatedData['tags']));

        // 3. Simpan data ke database
        Job::create([
            'user_id' => Auth::id(), // ID perusahaan yang sedang login
            'title' => $validatedData['title'],
            'location' => $validatedData['location'],
            'type' => $validatedData['type'],
            'description' => $validatedData['description'],
            'tags' => $tagsArray, // Simpan sebagai array
            'deadline' => $validatedData['deadline'],
        ]);

        // 4. Arahkan kembali ke halaman jobs dengan pesan sukses
        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil diposting!');
    }
    }

