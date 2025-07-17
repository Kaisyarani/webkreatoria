@extends('layouts.app')

@section('title', 'Notifikasi - Kreatoria')

@push('styles')
<style>
    /* CSS dari notifikasi.html */
    body {
        padding-top: var(--navbar-height, 88px);
    }
    .container {
        width: 90%;
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 0;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--bg-light);
    }
    .page-header h1 { font-size: 32px; }
    .header-actions { display: flex; gap: 15px; }
    .action-link {
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 14px;
        transition: color 0.3s ease;
    }
    .action-link:hover { color: var(--accent); }
    .notification-list {
        background-color: var(--bg-medium);
        border-radius: 12px;
        overflow: hidden;
    }
    .notification-item {
        display: flex;
        gap: 20px;
        padding: 20px;
        border-bottom: 1px solid var(--bg-light);
        transition: background-color 0.2s ease;
    }
    .notification-item:last-child { border-bottom: none; }
    .notification-item.unread {
        background-color: rgba(31, 41, 55, 0.7); /* Sedikit lebih gelap untuk menandakan belum dibaca */
    }
    .notification-item:hover { background-color: var(--bg-light); }
    .notif-icon {
        font-size: 20px;
        color: var(--accent);
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--bg-light);
        border-radius: 50%;
    }
    .notif-content { flex-grow: 1; }
    .notif-content p { line-height: 1.6; }
    .notif-content p strong { font-weight: 700; color: var(--text-primary); }
    .notif-time {
        font-size: 13px;
        color: var(--text-secondary);
        flex-shrink: 0;
    }
    .no-notifications {
        padding: 40px;
        text-align: center;
        color: var(--text-secondary);
    }
</style>
@endpush

@section('content')
<div class="container">
    <header class="page-header">
        <h1>Notifikasi</h1>
        <div class="header-actions">
            {{-- Link ini akan kita fungsikan di langkah selanjutnya --}}
            <a href="{{ route('notifications.markAllAsRead') }}" class="action-link">Tandai semua dibaca</a>
        </div>
    </header>

    <div class="notification-list">
        @forelse ($all_notifications as $notification)
            {{-- Tentukan link tujuan berdasarkan tipe notifikasi --}}
            @php
                $link = route('posts.show', ['post' => $notification->data['post_id'] ?? '#']);
            @endphp
            <a href="{{ $link }}" class="notification-item {{ $notification->read_at ? '' : 'unread' }}">
                <div class="notif-icon">
                    <i class="fas fa-comment-dots"></i>
                </div>
                <div class="notif-content">
                    <p>
                        <strong>{{ $notification->data['commenter_name'] ?? 'Seseorang' }}</strong>
                        mengomentari karya Anda
                        <strong>{{ $notification->data['post_title'] ?? 'sebuah postingan' }}</strong>.
                    </p>
                </div>
                <div class="notif-time">
                    {{ $notification->created_at->diffForHumans() }}
                </div>
            </a>
        @empty
            <div class="no-notifications">
                <p>Tidak ada notifikasi untuk ditampilkan.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
