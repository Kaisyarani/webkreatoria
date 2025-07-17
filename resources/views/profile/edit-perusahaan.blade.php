@extends('layouts.app')

@section('title', 'Edit Profil Perusahaan - Kreatoria')

@push('styles')
<style>
    /* Mengambil semua CSS dari perusa-profiledit.html */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap');
    body {
        padding-top: var(--navbar-height, 88px);
    }
    .container { width: 90%; max-width: 1100px; margin: 0 auto; padding: 40px 0; }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .page-header h1 { font-size: 28px; }
    .action-buttons .btn {
        background-color: var(--accent);
        color: var(--bg-dark);
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .action-buttons .btn:hover {
        background-color: #0E7490;
        color: var(--text-primary);
    }
    .action-buttons .btn-secondary {
        background-color: var(--bg-medium);
        color: var(--text-primary);
    }
    .action-buttons .btn-secondary:hover {
        background-color: var(--bg-light);
    }

    .profile-layout {
        display: flex;
        gap: 30px;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        flex-shrink: 0;
    }
    .logo-upload-wrapper {
        background-color: var(--bg-medium);
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 20px;
    }
    .logo-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 3px solid var(--bg-light);
        object-fit: cover;
        margin: 0 auto 15px auto;
        display: block;
    }
    .logo-upload-wrapper label {
        color: var(--accent);
        cursor: pointer;
        font-weight: 600;
    }
    #logo, #banner { display: none; }

    /* Main Content */
    .main-content {
        flex-grow: 1;
    }
    .form-section {
        background-color: var(--bg-medium);
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 20px;
    }
    .form-section h2 {
        font-size: 20px;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--bg-light);
    }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 8px; }
    .form-group input, .form-group textarea, .form-group select {
        width: 100%;
        padding: 12px;
        background-color: var(--bg-dark);
        border: 1px solid var(--bg-light);
        border-radius: 8px;
        color: var(--text-primary);
        font-size: 15px;
        font-family: inherit;
    }
    .form-group textarea { min-height: 120px; resize: vertical; }
    .form-group small {
        display: block;
        margin-top: 8px;
        color: var(--text-secondary);
        font-size: 13px;
    }
    .grid-2-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .banner-upload-wrapper {
        margin-bottom: 20px;
    }
    .banner-preview {
        width: 100%;
        height: 200px;
        border-radius: 8px;
        background-color: var(--bg-light);
        object-fit: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--text-secondary);
    }

    @media (max-width: 992px) {
        .profile-layout { flex-direction: column; }
        .sidebar { width: 100%; }
    }
    @media (max-width: 576px) {
        .grid-2-col { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 15px; }
    }
</style>
@endpush

@section('content')
<div class="container">
    <header class="page-header">
        <h1>Edit Profil Perusahaan</h1>
        <div class="action-buttons">
            <a href="{{ route('profile.show', Auth::user()) }}" class="btn btn-secondary">Batal</a>
            <button type="submit" form="company-profile-form" class="btn">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </header>

    @if (session('status') === 'profile-updated')
        <p style="color: var(--accent); margin-bottom: 20px; background-color: var(--bg-medium); padding: 10px; border-radius: 8px;">Profil berhasil disimpan.</p>
    @endif

    <div class="profile-layout">
        <aside class="sidebar">
            <div class="logo-upload-wrapper">
                <img src="{{ $profile->logo ? asset('storage/' . $profile->logo) : 'https://ui-avatars.com/api/?name='.$user->name.'&background=1F2937&color=F9FAFB&size=128' }}" alt="Logo Perusahaan" id="logo-preview" class="logo-preview">
                <label for="logo">Ubah Logo</label>
            </div>
        </aside>

        <main class="main-content">
            <form id="company-profile-form" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <input type="file" id="logo" name="logo" accept="image/*" style="display: none;">
                <input type="file" id="banner" name="banner" accept="image/*" style="display: none;">

                <div class="form-section">
                    <h2>Informasi Publik</h2>
                    <div class="banner-upload-wrapper">
                        <label for="banner" class="form-group-label">Gambar Banner</label>
                        <label for="banner">
                            <img src="{{ $profile->banner ? asset('storage/' . $profile->banner) : 'https://placehold.co/800x200/1F2937/9CA3AF?text=Klik+untuk+mengubah+banner' }}" alt="Banner" id="banner-preview" class="banner-preview">
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Perusahaan</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="tagline">Tagline</label>
                        <input type="text" id="tagline" name="tagline" placeholder="Contoh: We Build Awesome Digital Experiences" value="{{ old('tagline', $profile->tagline) }}">
                        <small>Slogan singkat yang mendeskripsikan perusahaan Anda.</small>
                    </div>
                    <div class="form-group">
                        <label for="description">Tentang Perusahaan</label>
                        <textarea id="description" name="description" placeholder="Jelaskan sejarah, visi, dan misi perusahaan Anda.">{{ old('description', $profile->description) }}</textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Detail & Kontak</h2>
                    <div class="grid-2-col">
                        <div class="form-group">
                            <label for="website">Situs Web</label>
                            <input type="url" id="website" name="website" placeholder="https://www.agensianda.com" value="{{ old('website', $profile->website) }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Kontak</label>
                            <input type="email" id="email" name="email" placeholder="kontak@agensianda.com" value="{{ old('email', $user->email) }}">
                        </div>
                        <div class="form-group">
                            <label for="industry">Industri</label>
                            <input type="text" id="industry" name="industry" placeholder="Contoh: Pemasaran & Periklanan" value="{{ old('industry', $profile->industry) }}">
                        </div>
                        <div class="form-group">
                            <label for="location">Lokasi</label>
                            <input type="text" id="location" name="location" placeholder="Contoh: Jakarta, Indonesia" value="{{ old('location', $profile->location) }}">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Tautan Sosial</h2>
                    <div class="grid-2-col">
                        <div class="form-group">
                            <label for="social_linkedin">LinkedIn</label>
                            <input type="url" id="social_linkedin" name="social_linkedin" placeholder="https://linkedin.com/company/agensianda" value="{{ old('social_linkedin', $profile->social_links['linkedin'] ?? '') }}">
                        </div>
                         <div class="form-group">
                            <label for="social_instagram">Instagram</label>
                            <input type="url" id="social_instagram" name="social_instagram" placeholder="https://instagram.com/agensianda" value="{{ old('social_instagram', $profile->social_links['instagram'] ?? '') }}">
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function setupImagePreview(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            if (!input || !preview) return;

            input.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        setupImagePreview('logo', 'logo-preview');
        setupImagePreview('banner', 'banner-preview');
    });
</script>
@endpush
