@extends('layouts.app')

@section('title', 'Profil Perusahaan: ' . $user->name)

@push('styles')
<style>
    /* Mengambil semua CSS dari profileperu.html */
    body {
        padding-top: var(--navbar-height, 88px);
    }
    .container { width: 90%; max-width: 1200px; margin: 0 auto; }

    /* Profile Header */
    .profile-header {
        position: relative;
        height: 350px;
        background-color: var(--bg-light);
        margin-bottom: 80px;
    }
    .profile-banner {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-header-content {
        position: absolute;
        bottom: -60px;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 900px;
        text-align: center;
    }
    .profile-logo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid var(--bg-dark);
        object-fit: cover;
        background-color: var(--bg-dark);
    }
    .profile-header h1 {
        font-size: 36px;
        margin-top: 10px;
    }
    .profile-header p {
        font-size: 18px;
        color: var(--text-secondary);
        margin-top: 5px;
    }
    .profile-header-actions {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; border: none; text-decoration: none; }
    .btn-primary { background-color: var(--accent); color: var(--bg-dark); }
    .btn-primary:hover { background-color: #0E7490; color: var(--text-primary); }
    .btn-secondary { background-color: var(--bg-medium); color: var(--text-primary); }
    .btn-secondary:hover { background-color: var(--bg-light); }

    /* Profile Body */
    .profile-body {
        padding: 40px 0;
        display: flex;
        gap: 30px;
    }
    .profile-main {
        flex-grow: 1;
    }
    .profile-sidebar {
        width: 300px;
        flex-shrink: 0;
    }
    .content-box {
        background-color: var(--bg-medium);
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 20px;
    }
    .content-box h2 {
        font-size: 22px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--bg-light);
    }
    .content-box .about-text {
        line-height: 1.8;
        color: var(--text-secondary);
    }

    /* Sidebar Info & Social */
    .info-list .info-item { display: flex; align-items: flex-start; gap: 15px; margin-bottom: 15px; }
    .info-list .info-item i { font-size: 16px; color: var(--text-secondary); margin-top: 5px; width: 20px; }
    .info-list .info-item div { font-size: 15px; }
    .info-list .info-item a { color: var(--accent); font-weight: 600; }
    .info-list .info-item a:hover { text-decoration: underline; }
    .social-links { display: flex; gap: 20px; }
    .social-links a { font-size: 24px; color: var(--text-secondary); transition: color 0.3s ease; }
    .social-links a:hover { color: var(--accent); }

    /* Tabs */
    .tab-nav { display: flex; gap: 10px; border-bottom: 1px solid var(--bg-medium); margin-bottom: 20px; }
    .tab-btn { background: none; border: none; color: var(--text-secondary); font-size: 16px; font-weight: 600; padding: 15px 20px; cursor: pointer; border-bottom: 3px solid transparent; }
    .tab-btn.active { color: var(--text-primary); border-bottom-color: var(--accent); }
    .tab-content { display: none; }
    .tab-content.active { display: block; }

    /* Jobs Grid */
    .items-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }
    .job-card {
        background-color: var(--bg-dark);
        padding: 20px;
        border-radius: 8px;
        border: 1px solid var(--bg-light);
    }
    .job-card h3 { font-size: 18px; margin-bottom: 5px; }
    .job-card p { color: var(--text-secondary); font-size: 14px; }
    .job-card a { color: var(--accent); display: block; margin-top: 15px; font-weight: 600; }

    @media (max-width: 992px) {
        .profile-body { flex-direction: column; }
        .profile-sidebar { width: 100%; order: -1; }
    }
</style>
@endpush

@section('content')
<header class="profile-header">
    <img src="{{ $profile->banner ? asset('storage/' . $profile->banner) : 'https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=2029' }}" alt="Banner Perusahaan" class="profile-banner">
    <div class="profile-header-content">
        <img src="{{ $profile->logo ? asset('storage/' . $profile->logo) : 'https://ui-avatars.com/api/?name='.$user->name.'&background=1F2937&color=F9FAFB&size=128' }}" alt="Logo Perusahaan" class="profile-logo">
        <h1>{{ $user->name }}</h1>
        <p>{{ $profile->tagline ?? 'Tagline perusahaan belum diatur' }}</p>
        <div class="profile-header-actions">
            {{-- Tombol Edit Profil ditambahkan di sini --}}
           @if(Auth::id() === $user->id)
            {{-- Jika ini profil saya, tampilkan tombol Edit --}}
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                <i class="fas fa-pencil-alt"></i> Edit Profil
            </a>
        @endif
            <a href="{{ route('chat.with', $user) }}" class="btn btn-secondary"><i class="fas fa-envelope"></i> Hubungi Kami</a>
        </div>
    </div>
</header>

<div class="container">
    <div class="profile-body">
        <main class="profile-main">
            <div class="content-box">
                <h2>Tentang Kami</h2>
                <p class="about-text">
                    {{ $profile->description ?? 'Deskripsi perusahaan belum diisi.' }}
                </p>
            </div>

            <div>
                <nav class="tab-nav">
                    <button class="tab-btn active" data-tab="jobs">Lowongan Pekerjaan ({{ $user->jobs->count() }})</button>
                    {{-- Tab Karya ditambahkan di sini --}}
                    <button class="tab-btn" data-tab="works">Karya (0)</button>
                </nav>

                <div id="jobs" class="tab-content active">
                    <div class="items-grid">
                        @forelse ($user->jobs as $job)
                            <div class="job-card">
                                <h3>{{ $job->title }}</h3>
                                <p>{{ $job->location }} • {{ $job->type }}</p>
                                <a href="{{ route('jobs.store', $job) }}">Lihat Detail</a>
                            </div>
                        @empty
                            <p style="color: var(--text-secondary); grid-column: 1 / -1;">Perusahaan ini belum membuka lowongan.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Konten untuk tab Karya ditambahkan di sini --}}
                <div id="works" class="tab-content">
                    <p style="text-align: center; color: var(--text-secondary); padding: 20px 0;">Galeri karya perusahaan akan ditampilkan di sini.</p>
                </div>
            </div>
        </main>

        <aside class="profile-sidebar">
            <div class="content-box">
                <h2>Informasi</h2>
                <div class="info-list">
                    @if($profile->website)
                    <div class="info-item">
                        <i class="fas fa-globe"></i>
                        <div><a href="{{ $profile->website }}" target="_blank" rel="noopener noreferrer">{{ $profile->website }}</a></div>
                    </div>
                    @endif
                    @if($profile->location)
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>{{ $profile->location }}</div>
                    </div>
                    @endif
                    @if($profile->industry)
                    <div class="info-item">
                        <i class="fas fa-briefcase"></i>
                        <div>{{ $profile->industry }}</div>
                    </div>
                    @endif
                </div>

                {{-- Blok Media Sosial ditambahkan di sini --}}
                 @if( !empty($profile->social_links['linkedin']) || !empty($profile->social_links['instagram']) )
                <hr style="border-color: var(--bg-light); margin: 20px 0;">
                <h2>Media Sosial</h2>
                <div class="social-links">
                    {{-- Cek untuk setiap link sebelum menampilkannya --}}
                    @if(isset($profile->social_links['linkedin']) && $profile->social_links['linkedin'])
                        <a href="{{ $profile->social_links['linkedin'] }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    @endif
                    @if(isset($profile->social_links['instagram']) && $profile->social_links['instagram'])
                        <a href="{{ $profile->social_links['instagram'] }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    @endif
                </div>
                @endif
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                button.classList.add('active');
                const targetContent = document.getElementById(button.dataset.tab);
                if (targetContent) {
                    targetContent.classList.add('active');
                }
            });
        });
    });
</script>
@endpush
