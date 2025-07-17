{{-- CSS untuk Notifikasi dan Navbar --}}
<style>
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        height: var(--navbar-height, 88px);
        padding: 0 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        z-index: 100;
        background-color: var(--bg-dark, #111827);
        border-bottom: 1px solid var(--bg-light, #374151);
    }
    .navbar .logo { flex-shrink: 0; font-size: 24px; font-weight: 800; color: var(--text-primary); text-decoration: none; }
    .nav-links {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 30px;
    }
    .navbar .nav-links a { color: var(--text-secondary, #9CA3AF); text-decoration: none; font-weight: 500; white-space: nowrap; }
    .navbar .nav-links a.active { color: var(--text-primary, #F9FAFB); }
    .navbar .nav-actions { display: flex; align-items: center; gap: 25px; flex-shrink: 0; margin-left: auto; }
    .profile-dropdown { position: relative; }
    .profile-btn { display: flex; align-items: center; gap: 10px; background: none; border: none; cursor: pointer; }
    .profile-img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
    .profile-name { color: var(--text-primary, #F9FAFB); font-weight: 600; }
    .dropdown-menu { display: none; position: absolute; top: 60px; right: 0; background-color: var(--bg-medium, #1F2937); border: 1px solid var(--bg-light, #374151); border-radius: 8px; overflow: hidden; z-index: 110; min-width: 180px; }
    .dropdown-menu.show { display: block; }
    .dropdown-menu a { display: block; padding: 12px 20px; color: var(--text-secondary, #9CA3AF); font-size: 14px; }
    .dropdown-menu a:hover { background-color: var(--bg-light, #374151); color: var(--text-primary, #F9FAFB); }
    #logout-btn { color: #ef4444; }
    .nav-button { padding: 8px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; }
    .nav-button-primary { background-color: var(--accent, #22D3EE); color: var(--bg-dark, #111827); }
    .nav-button-secondary { border: 1px solid var(--bg-light, #374151); }
    .nav-icon-btn { position: relative; color: var(--text-primary, #F9FAFB); font-size: 20px; text-decoration: none; transition: color 0.3s ease; }
    .nav-icon-btn:hover { color: var(--accent, #22D3EE); }
    .notification-badge {
        position: absolute;
        top: -4px;
        right: -6px;
        width: 18px;
        height: 18px;
        background-color: #ef4444;
        color: var(--text-primary, #F9FAFB);
        border-radius: 50%;
        border: 2px solid var(--bg-dark, #111827);
        font-size: 10px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .notification-dropdown {
        display: none;
        position: absolute;
        top: 60px;
        right: 0;
        width: 360px;
        background-color: var(--bg-medium, #1F2937);
        border: 1px solid var(--bg-light, #374151);
        border-radius: 12px;
        z-index: 120;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .notification-dropdown.show { display: block; }
    .notif-header { display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid var(--bg-light, #374151); }
    .notif-header h3 { font-size: 16px; font-weight: 700; }
    .notif-header a { font-size: 13px; color: var(--accent, #22D3EE); font-weight: 600; }
    .notif-list { max-height: 400px; overflow-y: auto; }
    .notif-item { display: flex; gap: 15px; padding: 15px 20px; border-bottom: 1px solid var(--bg-light, #374151); }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background-color: var(--bg-light, #374151); }
    .notif-icon { font-size: 18px; color: var(--accent, #22D3EE); flex-shrink: 0; }
    .notif-content p { font-size: 14px; line-height: 1.5; color: var(--text-secondary, #9CA3AF); }
    .notif-content p strong { color: var(--text-primary, #F9FAFB); }
    .notif-footer { padding: 15px; text-align: center; background-color: var(--bg-dark, #111827); }
    .notif-footer a { color: var(--accent, #22D3EE); font-weight: 600; }
</style>

<nav class="navbar">
    <a href="{{ url('/') }}" class="logo">Kreatoria</a>

    <div class="nav-links">
        <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
        <a href="{{ route('gallery.index') }}" class="{{ request()->routeIs('gallery.index') ? 'active' : '' }}">Gallery</a>
        <a href="{{ route('jobs.index') }}" class="{{ request()->routeIs('jobs.index') ? 'active' : '' }}">Jobs</a>
        <a href="{{ route('explore.index') }}" class="{{ request()->routeIs('explore.index') ? 'active' : '' }}">Eksplorasi Talenta</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
    </div>

    <div class="nav-actions">
        @auth
            {{-- Tombol Notifikasi --}}
            <div style="position: relative;">
                <button id="notification-btn" class="nav-icon-btn" style="background:none; border:none; cursor:pointer;">
                    <i class="fas fa-bell"></i>
                    {{-- Ini adalah blok @if yang mungkin hilang penutupnya --}}
                    @if($notifications->count() > 0)
                        <span class="notification-badge">{{ $notifications->count() }}</span>
                    @endif
                </button>

                {{-- Dropdown Notifikasi --}}
                <div id="notification-dropdown" class="notification-dropdown">
                    <div class="notif-header">
                        <h3>Notifikasi</h3>
                        <a href="#">Tandai Dibaca</a>
                    </div>
                    <div class="notif-list">
                        @forelse ($notifications as $notification)
                            <a href="#" class="notif-item">
                                <div class="notif-icon"><i class="fas fa-comment-dots"></i></div>
                                <div class="notif-content">
                                    <p><strong>{{ $notification->data['commenter_name'] ?? 'Seseorang' }}</strong> mengomentari <strong>{{ $notification->data['post_title'] ?? 'karya Anda' }}</strong></p>
                                </div>
                            </a>
                        @empty
                            <div class="notif-item">
                                <p style="color: var(--text-secondary);">Tidak ada notifikasi baru.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="notif-footer">
                        <a href="{{ route('notifications.index') }}">Lihat Semua Notifikasi</a>
                    </div>
                </div>
            </div>

            {{-- Dropdown Profil Pengguna --}}
            <div class="profile-dropdown">
                <button class="profile-btn">
                    @php
                        $photo = optional(Auth::user()->kreatorProfile)->photo;
                        $logo = optional(Auth::user()->perusahaanProfile)->logo;
                        $avatarUrl = $photo ? asset('storage/' . $photo) : ($logo ? asset('storage/' . $logo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=374151&color=F9FAFB');
                    @endphp
                    <img src="{{ $avatarUrl }}" alt="Avatar" class="profile-img">
                    <span class="profile-name">{{ Auth::user()->name }}</span>
                </button>
                <div class="dropdown-menu">
                    <a href="{{ route('profile.show', Auth::user()) }}">Profil Saya</a>
                    <a href="{{ route('profile.settings') }}">Pengaturan</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" id="logout-btn" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="nav-button nav-button-secondary">Login</a>
            <a href="{{ route('register') }}" class="nav-button nav-button-primary">Sign Up</a>
        @endauth
    </div>
</nav>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const profileDropdown = document.querySelector('.profile-dropdown');
    if (profileDropdown) {
        const profileBtn = profileDropdown.querySelector('.profile-btn');
        const profileMenu = profileDropdown.querySelector('.dropdown-menu');
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileMenu.classList.toggle('show');
        });
    }

    const notificationBtn = document.getElementById('notification-btn');
    const notificationDropdown = document.getElementById('notification-dropdown');
    if (notificationBtn && notificationDropdown) {
        notificationBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            notificationDropdown.classList.toggle('show');
        });
    }

    window.addEventListener('click', (e) => {
        const profileMenu = document.querySelector('.profile-dropdown .dropdown-menu');
        if (profileMenu && profileMenu.classList.contains('show')) {
            profileMenu.classList.remove('show');
        }
        if (notificationDropdown && notificationDropdown.classList.contains('show')) {
            notificationDropdown.classList.remove('show');
        }
    });
});
</script>
@endpush
