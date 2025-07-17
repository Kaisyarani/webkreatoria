@extends('layouts.app')

@section('title', $post->title)

@push('styles')
<style>
    body {
        padding-top: var(--navbar-height, 88px);
    }
    .post-container {
        display: grid;
        grid-template-columns: 1fr 320px; /* Kolom utama dan sidebar */
        gap: 40px;
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
    .post-main {
        background-color: var(--bg-medium);
        border-radius: 12px;
        overflow: hidden;
    }
    .post-image {
        width: 100%;
        height: auto;
        max-height: 600px;
        object-fit: cover;
        background-color: var(--bg-dark);
    }
    .post-content {
        padding: 30px;
    }
    .post-sidebar {
        position: sticky;
        top: calc(var(--navbar-height, 88px) + 20px);
        height: fit-content;
    }
    .sidebar-box {
        background-color: var(--bg-medium);
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
    }

    /* Detail Penulis */
    .author-box h2 {
        font-size: 16px;
        color: var(--text-secondary);
        margin-bottom: 15px;
        font-weight: 600;
    }
    .author-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .author-info img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
    .author-info .name {
        font-weight: 700;
        font-size: 18px;
    }
    .author-info .title {
        color: var(--text-secondary);
        font-size: 14px;
    }

    /* Aksi Postingan */
    .post-actions h2 {
        font-size: 16px;
        color: var(--text-secondary);
        margin-bottom: 20px;
        font-weight: 600;
    }
    .actions-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px;
        border-radius: 8px;
        background-color: var(--bg-light);
        color: var(--text-primary);
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .action-btn:hover { background-color: #4B5563; }
    .action-btn.liked { color: #ef4444; }
    .owner-actions {
        margin-top: 15px;
        display: flex;
        flex-direction: column;
        gap: 10px; /* Memberi jarak antar tombol */
    }
    .btn-delete {
        grid-column: 1 / -1; /* Tombol hapus mengambil lebar penuh */
        background-color: #ef44441a;
        color: #ef4444;
        border: 1px solid #ef4444;
    }
    .btn-delete:hover { background-color: #ef444433; }

    /* Konten Utama Postingan */
    .post-title {
        font-size: 32px;
        margin-bottom: 10px;
    }
    .post-date {
        color: var(--text-secondary);
        margin-bottom: 25px;
    }
    .post-description {
        line-height: 1.8;
        color: var(--text-primary);
    }

    /* Bagian Komentar */
    .comments-section {
        margin-top: 30px;
        border-top: 1px solid var(--bg-light);
        padding-top: 30px;
    }
    .comments-section h3 { font-size: 20px; margin-bottom: 20px; }
    .comment-form textarea { width: 100%; background-color: var(--bg-dark); border: 1px solid var(--bg-light); border-radius: 8px; padding: 15px; color: var(--text-primary); min-height: 100px; margin-bottom: 15px; }
    .comment-form button { background-color: var(--accent); color: var(--bg-dark); border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; cursor: pointer; float: right; }
    .comment-list { list-style: none; padding: 0; margin-top: 40px; clear: both; }
    .comment-item { display: flex; gap: 15px; margin-bottom: 25px; }
    .comment-item img { width: 40px; height: 40px; border-radius: 50%; }
    .comment-body .author-name { font-weight: 700; }
    .comment-body .comment-text { color: var(--text-secondary); margin-top: 5px; }

    /* Modal Styles */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.8); z-index: 1000; display: none; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease; }
    .modal-overlay.show { display: flex; opacity: 1; }
    .modal-box { background-color: var(--bg-medium); padding: 40px; border-radius: 12px; width: 90%; max-width: 400px; text-align: center; }
    .modal-box h2 { font-size: 24px; margin-bottom: 15px; }
    .modal-box p { color: var(--text-secondary); margin-bottom: 30px; line-height: 1.6; }
    .modal-actions { display: flex; justify-content: center; gap: 20px; }
    .btn { padding: 10px 24px; border-radius: 8px; font-weight: 700; cursor: pointer; border: none; }
    .btn-secondary { background-color: var(--bg-light); color: var(--text-primary); }
    .btn-danger { background-color: #ef4444; color: var(--text-primary); }

    /* Responsif */
    @media (max-width: 992px) {
        .post-container {
            grid-template-columns: 1fr;
        }
        .post-sidebar {
            position: static;
        }
    }
</style>
@endpush

@section('content')
<div class="post-container">
    <main class="post-main">
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="post-image">
        <div class="post-content">
            <h1 class="post-title">{{ $post->title }}</h1>
            <p class="post-date">Diposting pada {{ $post->created_at->format('d F Y') }}</p>
            <div class="post-description">
                <p>{{ $post->description ?? 'Tidak ada deskripsi untuk karya ini.' }}</p>
            </div>

            <div id="comments-section" class="comments-section">
                <h3>Komentar ({{ $post->comments->count() }})</h3>
                @auth
                <form class="comment-form" method="POST" action="{{ route('comments.store', $post) }}">
                    @csrf
                    <textarea name="body" placeholder="Tulis komentar Anda..." required></textarea>
                    <button type="submit">Kirim</button>
                </form>
                @else
                <p>Silakan <a href="{{ route('login') }}" style="color: var(--accent);">login</a> untuk menulis komentar.</p>
                @endauth

                <ul class="comment-list">
                    @forelse ($post->comments->sortByDesc('created_at') as $comment)
                        <li class="comment-item">
                            <img src="{{ optional($comment->user->kreatorProfile)->photo ? asset('storage/' . $comment->user->kreatorProfile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name) }}" alt="{{ $comment->user->name }}">
                            <div class="comment-body">
                                <span class="author-name">{{ $comment->user->name }}</span>
                                <p class="comment-text">{{ $comment->body }}</p>
                            </div>
                        </li>
                    @empty
                        <p style="color: var(--text-secondary); text-align: center; padding: 20px 0;">Jadilah yang pertama berkomentar!</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </main>

    <aside class="post-sidebar">
        <div class="sidebar-box author-box">
            <h2>Tentang Kreator</h2>
            <a href="{{ route('profile.show', $post->user) }}" class="author-info">
                <img src="{{ optional($post->user->kreatorProfile)->photo ? asset('storage/' . $post->user->kreatorProfile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($post->user->name) }}" alt="{{ $post->user->name }}">
                <div>
                    <div class="name">{{ $post->user->name }}</div>
                    <div class="title">{{ optional($post->user->kreatorProfile)->title ?? 'Kreator' }}</div>
                </div>
            </a>
        </div>

        <div class="sidebar-box post-actions">
            <h2>Aksi</h2>
            <div class="actions-grid">
                <button class="action-btn like-btn {{ Auth::check() && Auth::user()->likes->contains($post) ? 'liked' : '' }}" data-post-id="{{ $post->id }}">
                    <i class="fas fa-heart"></i>
                    <span class="like-count">{{ $post->likes->count() }}</span>
                </button>
                <button class="action-btn share-btn" data-url="{{ route('posts.show', $post) }}" data-title="{{ $post->title }}">
                    <i class="fas fa-share-alt"></i>
                    <span>Bagikan</span>
                </button>
            </div>
            @can('update', $post)
                <div class="owner-actions">
                    <a href="{{ route('posts.edit', $post) }}" class="action-btn btn-edit" style="width: 100%;">
                        <i class="fas fa-pencil-alt"></i> Update Karya
                    </a>
                    <button id="delete-post-btn" class="action-btn btn-delete" style="width: 100%;">
                        <i class="fas fa-trash"></i> Hapus Karya
                    </button>
                </div>
            @endcan
        </div>
    </aside>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div id="delete-confirm-modal" class="modal-overlay">
    <div class="modal-box">
        <h2>Konfirmasi Penghapusan</h2>
        <p>Apakah Anda yakin ingin menghapus karya ini? Tindakan ini tidak dapat diurungkan.</p>
        <div class="modal-actions">
            <button id="cancel-delete-btn" class="btn btn-secondary">Batal</button>
            <form id="delete-post-form" method="POST" action="{{ route('posts.destroy', $post) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    // Logika untuk Tombol Like
    const likeBtn = document.querySelector('.like-btn');
    if (likeBtn) {
        likeBtn.addEventListener('click', function() {
            @auth
            const postId = this.dataset.postId;
            const likeCountSpan = this.querySelector('.like-count');

            fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Gagal menyukai postingan.');
                return response.json();
            })
            .then(data => {
                likeCountSpan.textContent = data.likes_count;
                this.classList.toggle('liked', data.user_has_liked);
            })
            .catch(error => console.error('Error:', error));
            @else
            window.location.href = "{{ route('login') }}";
            @endauth
        });
    }

    // Logika untuk Tombol Share
    const shareBtn = document.querySelector('.share-btn');
    if (shareBtn) {
        shareBtn.addEventListener('click', async function() {
            const url = this.dataset.url;
            const title = this.dataset.title;
            const shareData = {
                title: `Karya: ${title}`,
                text: `Lihat karya keren "${title}" di Kreatoria!`,
                url: url
            };
            try {
                if (navigator.share) {
                    await navigator.share(shareData);
                } else {
                    await navigator.clipboard.writeText(url);
                    alert('Link karya telah disalin ke clipboard!');
                }
            } catch (err) {
                console.error("Error sharing:", err);
                alert('Gagal membagikan, mungkin browser Anda tidak mendukung fitur ini.');
            }
        });
    }

    // Logika untuk Modal Hapus
    const deleteBtn = document.getElementById('delete-post-btn');
    const cancelBtn = document.getElementById('cancel-delete-btn');
    const modal = document.getElementById('delete-confirm-modal');

    if (deleteBtn && modal) {
        deleteBtn.addEventListener('click', () => modal.classList.add('show'));
    }
    if (cancelBtn && modal) {
        cancelBtn.addEventListener('click', () => modal.classList.remove('show'));
    }
    if (modal) {
        modal.addEventListener('click', (event) => {
            if (event.target === modal) modal.classList.remove('show');
        });
    }
});
</script>
@endpush
