@extends('layouts.app')

@section('title', 'Profil ' . $user->name)

@push('styles')
<style>
    /* CSS Khusus untuk halaman profil kreator */
     #main-profile-view {
            padding-top: var(--navbar-height);
        }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; }
        .profile-header { position: relative; height: 350px; background-color: var(--bg-light); margin-bottom: 120px; }
        .profile-banner { width: 100%; height: 100%; object-fit: cover; }
        .profile-header-content { position: absolute; bottom: -100px; left: 50%; transform: translateX(-50%); width: 100%; max-width: 900px; text-align: center; }
        .profile-photo { width: 120px; height: 120px; border-radius: 50%; border: 4px solid var(--bg-dark); object-fit: cover; background-color: var(--bg-dark); }
        .profile-header h1 { font-size: 36px; margin-top: 10px; }
        .profile-header .header-title { font-size: 18px; color: var(--accent); margin-top: 5px; font-weight: 500; }
        .profile-stats { margin-top: 15px; display: flex; justify-content: center; gap: 30px; }
        .stat-item { color: var(--text-secondary); font-size: 16px; }
        .stat-item strong { color: var(--text-primary); font-weight: 700; }
        .profile-header-actions { margin-top: 20px; display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; border: none; }
        .btn-primary { background-color: var(--accent); color: var(--bg-dark); }
        .btn-secondary { background-color: var(--bg-medium); color: var(--text-primary); }
        .profile-body { padding: 40px 0; display: flex; gap: 30px; }
        .profile-main { flex-grow: 1; }
        .profile-sidebar { width: 300px; flex-shrink: 0; }
        .content-box { background-color: var(--bg-medium); padding: 30px; border-radius: 12px; margin-bottom: 20px; }
        .content-box h2 { font-size: 22px; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid var(--bg-light); }
        .tab-nav { display: flex; flex-wrap: wrap; gap: 10px; border-bottom: 1px solid var(--bg-medium); margin-bottom: 20px; }
        .tab-btn { background: none; border: none; color: var(--text-secondary); font-size: 16px; font-weight: 600; padding: 15px 20px; cursor: pointer; border-bottom: 3px solid transparent; }
        .tab-btn.active { color: var(--text-primary); border-bottom-color: var(--accent); }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .about-text { line-height: 1.8; color: var(--text-secondary); }
        .skills-container { display: flex; flex-wrap: wrap; gap: 12px; }
        .skill-tag { background-color: var(--bg-light); color: var(--text-primary); padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 14px; }
        .social-links { display: flex; gap: 20px; margin-top: 20px;}
        .social-links a { font-size: 24px; color: var(--text-secondary); transition: color 0.3s ease; }
        .social-links a:hover { color: var(--accent); }
        .timeline { list-style: none; padding: 0; }
        .timeline-item { position: relative; padding-bottom: 30px; padding-left: 30px; border-left: 2px solid var(--bg-light); }
        .timeline-item:last-child { border-left: 2px solid transparent; padding-bottom: 0; }
        .timeline-item::before { content: ''; position: absolute; left: -9px; top: 4px; width: 16px; height: 16px; border-radius: 50%; background-color: var(--accent); border: 3px solid var(--bg-medium); }
        .timeline-item h3 { font-size: 18px; margin-bottom: 2px; }
        .timeline-item .meta { color: var(--text-secondary); margin-bottom: 4px; font-weight: 500; }
        .timeline-item .date { font-size: 14px; color: var(--accent); }

        @media (max-width: 992px) {
            .profile-body { flex-direction: column; }
            .profile-sidebar { width: 100%; order: -1; }
            /* Sembunyikan link nav utama, tampilkan hamburger */
            .nav-links { display: none; }
            .hamburger-menu { display: block; background: none; border: none; cursor: pointer; z-index: 1001;}
            .hamburger-menu .bar { display: block; width: 25px; height: 3px; background-color: var(--text-primary); margin: 5px 0; transition: all 0.3s ease-in-out; }
            .navbar-menu { position: absolute; top: var(--navbar-height); left: 0; width: 100%; background-color: var(--bg-medium); flex-direction: column; align-items: center; gap: 0; padding: 20px 0; max-height: 0; overflow: hidden; transition: max-height 0.5s ease-out; }
            .navbar-menu.active { max-height: 500px; }
            .navbar-menu .nav-links { display: flex; flex-direction: column; gap: 25px; margin-bottom: 25px; }
        }
        @media (max-width: 576px) { .profile-header { height: 280px; margin-bottom: 100px; } .profile-header-content { bottom: -80px; } .profile-photo { width: 100px; height: 100px; } .profile-header h1 { font-size: 28px; } }

    /* ================== PERBAIKAN CSS GALERI KARYA ================== */
        .project-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Ukuran gambar lebih kecil */
            gap: 15px;
        }
        .project-card img {
            width: 100%;
            height: 160px; /* Tinggi gambar disesuaikan */
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }
        .project-card img:hover {
            transform: scale(1.05);
        }
        /* =============================================================== */
        .modal { position: fixed; z-index: 1001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); display: none; align-items: center; justify-content: center; }
        .modal-content { background-color: var(--bg-medium); padding: 30px; border-radius: 12px; text-align: center; max-width: 400px; border: 1px solid var(--bg-light); }
        .modal-content p { margin-bottom: 20px; }
</style>
@endpush

@section('content')
    <div id="main-profile-view">
        <header class="profile-header">
            <img src="{{ $profile->banner ? asset('storage/' . $profile->banner) : 'https://images.unsplash.com/photo-1522252234503-e356532cafd5?q=80&w=2070' }}" alt="Banner" class="profile-banner">
            <div class="profile-header-content">
                <img src="{{ $profile->photo ? asset('storage/' . $profile->photo) : 'https://ui-avatars.com/api/?name='.$user->name.'&background=111827&color=F9FAFB&size=128' }}" alt="Foto Profil" class="profile-photo">
                <h1>{{ $user->name }}</h1>
                <p class="header-title">{{ $profile->title ?? 'Jabatan Belum Diatur' }}</p>
                <div class="profile-stats">
                    <div class="stat-item"><strong>{{ $user->posts->count() }}</strong> Karya</div>
                    <div class="stat-item"><strong>0</strong> Jaringan</div>
                </div>
              <div class="profile-header-actions">
        @auth
        @if(Auth::id() === $user->id)
            {{-- Jika ini profil saya, tampilkan tombol Edit --}}
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                <i class="fas fa-pencil-alt"></i> Edit Profil
            </a>
        @endif
        {{-- Tombol Chat selalu tampil --}}
        <a href="{{ route('chat.with', $user) }}" class="btn btn-secondary">
            <i class="fas fa-comment-dots"></i> Kirim Pesan
        </a>
            @endauth

        {{-- Tombol Bagikan selalu tampil --}}
        <button class="btn btn-secondary" id="share-profile-btn">
         <i class="fas fa-share-alt"></i> Bagikan Profil </button>
        </div>
        </header>
        <main class="container">
            <div class="profile-body">
                <div class="profile-main">
                     <nav class="tab-nav">
                        <button class="tab-btn active" data-tab="karya">Karya</button>
                        <button class="tab-btn" data-tab="pengalaman">Pengalaman</button>
                        <button class="tab-btn" data-tab="pendidikan">Pendidikan</button>
                    </nav>

                <div id="karya" class="tab-content active">
                    <div class="content-box">
                        <h2>Galeri Karya</h2>
                        <div class="project-grid">
                            @forelse ($user->posts as $post)
                                <div class="project-card">
                                    <a href="{{ route('posts.show', $post) }}">
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                                    </a>
                                </div>
                            @empty
                                <p style="text-align: center; color: var(--text-secondary); grid-column: 1 / -1;">Pengguna ini belum memiliki karya.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div id="pengalaman" class="tab-content">
                    <div class="content-box">
                        <h2>Riwayat Pengalaman</h2>
                        <ul class="timeline">
                            @forelse ($profile->experience ?? [] as $exp)
                                @if (!empty($exp['title']))
                                    <li class="timeline-item">
                                        <h3>{{ $exp['title'] }}</h3>
                                        <p class="meta">{{ $exp['company'] ?? 'Nama Perusahaan' }}</p>
                                        <p class="date">
                                            {{ $exp['start'] ? \Carbon\Carbon::parse($exp['start'])->format('M Y') : 'N/A' }} -
                                            {{ $exp['end'] ? \Carbon\Carbon::parse($exp['end'])->format('M Y') : 'Sekarang' }}
                                        </p>
                                    </li>
                                @endif
                            @empty
                                <p style="color: var(--text-secondary);">Belum ada pengalaman kerja yang ditambahkan.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div id="pendidikan" class="tab-content">
                    <div class="content-box">
                        <h2>Riwayat Pendidikan</h2>
                        <ul class="timeline">
                             @forelse ($profile->education ?? [] as $edu)
                                @if (!empty($edu['school']))
                                    <li class="timeline-item">
                                        <h3>{{ $edu['school'] }}</h3>
                                        <p class="meta">{{ $edu['degree'] ?? 'Gelar' }}</p>
                                        <p class="date">Lulus {{ $edu['year'] ?? 'N/A' }}</p>
                                    </li>
                                @endif
                            @empty
                                <p style="color: var(--text-secondary);">Belum ada riwayat pendidikan yang ditambahkan.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
                </div>
                <aside class="profile-sidebar">
                      <div class="content-box">
                        <h2>Ringkasan</h2>
                        {{-- Menampilkan data 'about' langsung dari variabel $profile --}}
                        <p class="about-text">{{ $profile->about ?? 'Ringkasan belum diatur oleh pengguna.' }}</p>
                    </div>
                    <div class="content-box">
                        <h2>Keahlian</h2>
                        <div class="skills-container">
                            {{-- Menampilkan data 'skills' langsung dari variabel $profile --}}
                            @forelse ($profile->skills ?? [] as $skill)
                                <span class="skill-tag">{{ $skill }}</span>
                            @empty
                                <p style="color: var(--text-secondary);">Belum ada keahlian yang ditambahkan.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="content-box">
                        <h2>Media Sosial</h2>
                        <div class="social-links">
                             {{-- Menampilkan data 'social_links' langsung dari variabel $profile --}}
                            @if(isset($profile->social_links['linkedin']) && $profile->social_links['linkedin'])
                                <a href="{{ $profile->social_links['linkedin'] }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin"></i></a>
                            @endif
                            @if(isset($profile->social_links['dribbble']) && $profile->social_links['dribbble'])
                                <a href="{{ $profile->social_links['dribbble'] }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-dribbble"></i></a>
                            @endif
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    </div>

    <div id="notification-modal" class="modal">
        <div class="modal-content">
            <p id="modal-message"></p>
            <button id="modal-close-btn" class="btn btn-primary">Tutup</button>
        </div>
    </div>
@endsection

@push('scripts')
<script>
   document.addEventListener('DOMContentLoaded', () => {
        // --- SCRIPT BERSIH UNTUK HALAMAN INI ---

        // Logika pindah tab
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelector('.tab-btn.active').classList.remove('active');
                document.querySelector('.tab-content.active').classList.remove('active');
                button.classList.add('active');
                document.getElementById(button.dataset.tab).classList.add('active');
            });
        });

        // Logika untuk modal notifikasi
        const modal = document.getElementById('notification-modal');
        const modalMessage = document.getElementById('modal-message');
        const closeModalBtn = document.getElementById('modal-close-btn');
        if(modal) closeModalBtn.addEventListener('click', () => modal.style.display = 'none');
        function showModal(message) {
            modalMessage.textContent = message;
            modal.style.display = 'flex';
        }

        // Logika untuk tombol Bagikan Profil
        const shareBtn = document.getElementById('share-profile-btn');
        if(shareBtn) {
            shareBtn.addEventListener('click', async () => {
                const shareData = {
                    title: 'Profil Kreatoria',
                    text: 'Lihat profil kreatif {{ addslashes($user->name) }} di Kreatoria!',
                    url: window.location.href
                };
                try {
                    if (navigator.share) {
                        await navigator.share(shareData);
                    } else {
                        await navigator.clipboard.writeText(window.location.href);
                        showModal('Link profil telah disalin ke clipboard!');
                    }
                } catch (err) {
                    console.error("Share error: " + err);
                }
            });
        }
    });
</script>
@endpush
