@extends('layouts.app')

@section('title', 'Gallery Karya - Kreatoria')

@push('styles')
<style>
    /* Menggunakan style yang sama dengan gallerykreator untuk konsistensi */
    body {
        padding-top: var(--navbar-height, 88px);
    }
    .container {
      width: 90%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 10px 0;
    }
    .page-header { text-align: center; padding: 60px 20px; }
    .page-header h1 { font-size: 42px; margin-bottom: 10px; }
    .page-header p { font-size: 18px; color: var(--text-secondary); max-width: 600px; margin: 0 auto; }

    .gallery-container { padding-top: 5px; }
    .gallery-controls { display: flex; flex-direction: column; gap: 30px; margin-bottom: 50px; align-items: center; }
    .search-wrapper { position: relative; width: 100%; max-width: 500px; }
    #search-bar { width: 100%; padding: 14px 50px; background-color: var(--bg-medium); border: 1px solid var(--bg-light); border-radius: 8px; color: var(--text-primary); font-size: 16px; }
    .search-wrapper .icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); }
    .filter-bar { display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; }
    .filter-btn { background-color: var(--bg-medium); border: 1px solid var(--bg-light); padding: 10px 22px; border-radius: 30px; cursor: pointer; font-weight: 600; transition: all 0.3s ease; }
    .filter-btn.active, .filter-btn:hover { background-color: var(--accent); color: var(--bg-dark); border-color: var(--accent); }

    .project-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
    .project-card { display: flex; flex-direction: column; background-color: var(--bg-medium); border-radius: 12px; overflow: hidden; transition: transform 0.3s ease; }
    .project-card:hover { transform: translateY(-5px); }
    .project-card-image-link { display: block; width: 100%; height: 220px; background-color: var(--bg-light); }
    .project-card-image { width: 100%; height: 100%; object-fit: cover; }
    .project-card-content { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
    .project-card-content h3 { font-size: 20px; margin-bottom: 8px; }
    .project-card-content .author { color: var(--text-secondary); font-size: 14px; margin-bottom: 15px; }
    .project-card-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--bg-light); padding: 10px 20px; margin-top: auto; }
    .card-actions { display: flex; align-items: center; gap: 5px; }
    .action-btn { display: flex; align-items: center; gap: 8px; color: var(--text-secondary); font-weight: 600; font-size: 14px; background-color: var(--bg-light); border: none; cursor: pointer; padding: 8px 12px; border-radius: 20px; transition: all 0.2s ease; text-decoration: none; }
    .action-btn:hover { background-color: #4B5563; color: var(--text-primary); }
    .share-btn { padding: 8px; width: 36px; height: 36px; justify-content: center; }
    .action-btn.liked { background-color: #ef444433; color: #ef4444; }
</style>
@endpush

@section('content')
<header class="page-header">
    <h1>Eksplorasi Karya Mengagumkan</h1>
    <p>Temukan inspirasi dari ribuan karya yang dibuat oleh para talenta terbaik di komunitas Kreatoria.</p>
</header>
<div class="container gallery-container">
    <div class="gallery-controls">
        <div class="search-wrapper">
            <span class="icon"><i class="fas fa-search"></i></span>
            <input type="text" id="search-bar" placeholder="Cari berdasarkan judul atau kreator...">
        </div>
        <div class="filter-bar">
            <button class="filter-btn active" data-filter="all">Semua</button>
            <button class="filter-btn" data-filter="ui-ux">UI/UX Design</button>
            <button class="filter-btn" data-filter="branding">Branding</button>
            <button class="filter-btn" data-filter="ilustrasi">Ilustrasi</button>
            <button class="filter-btn" data-filter="web-dev">Web Development</button>
        </div>
    </div>

    <div class="project-grid" id="project-grid-container">
        {{-- Loop melalui data $posts yang dikirim dari controller --}}
        @forelse ($posts as $post)
            <div class="project-card" data-category="{{ $post->category }}">
                {{-- Link sekarang mengarah ke halaman detail postingan --}}
                <a href="{{ route('posts.show', $post) }}" class="project-card-image-link">
                    <img class="project-card-image" src="{{ asset('storage/' . $post->image) }}" alt="Gambar karya {{ $post->title }}">
                </a>
                {{-- ======================================================= --}}
                <div class="project-card-content">
                    <h3>{{ $post->title }}</h3>
                    <p class="author">Oleh: {{ $post->user->name }}</p>
                </div>
                <div class="project-card-footer">
                    <div class="card-actions">
                        <button class="action-btn like-btn {{ Auth::check() && Auth::user()->likes->contains($post) ? 'liked' : '' }}" data-post-id="{{ $post->id }}">
                            <i class="fas fa-heart"></i>
                            <span class="like-count">{{ $post->likes->count() }}</span>
                        </button>
                        <a href="{{ route('posts.show', $post) }}#comments-section" class="action-btn">
                            <i class="far fa-comment"></i>
                            <span>{{ $post->comments->count() }}</span>
                        </a>
                    </div>
                    <div class="card-actions">
                        <button class="action-btn share-btn" data-url="{{ route('posts.show', $post) }}" data-title="{{ $post->title }}">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p style="color: var(--text-secondary); text-align: center; grid-column: 1 / -1; padding: 40px 0;">
                Belum ada karya yang bisa ditampilkan.
            </p>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
// Menambahkan skrip yang sama dari gallerykreator untuk fungsionalitas
document.addEventListener('DOMContentLoaded', () => {
    // --- Logika untuk Filter dan Search ---
    const filterButtons = document.querySelectorAll('.filter-btn');
    const searchBar = document.getElementById('search-bar');
    const projectCards = document.querySelectorAll('.project-card');

    function filterAndSearch() {
        const searchTerm = searchBar.value.toLowerCase();
        const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;

        projectCards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const author = card.querySelector('.author').textContent.toLowerCase();
            const category = card.dataset.category;

            const matchesFilter = (activeFilter === 'all') || (category === activeFilter);
            const matchesSearch = title.includes(searchTerm) || author.includes(searchTerm);

            if (matchesFilter && matchesSearch) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }
    filterButtons.forEach(button => button.addEventListener('click', () => {
        document.querySelector('.filter-btn.active').classList.remove('active');
        button.classList.add('active');
        filterAndSearch();
    }));
    if (searchBar) {
        searchBar.addEventListener('input', filterAndSearch);
    }

    // --- Logika untuk Tombol Like (AJAX) ---
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
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
            .then(response => response.json())
            .then(data => {
                likeCountSpan.textContent = data.likes_count;
                this.classList.toggle('liked', data.user_has_liked);
            })
            .catch(error => console.error('Error:', error));
            @else
            window.location.href = "{{ route('login') }}";
            @endauth
        });
    });

    // --- Logika untuk Tombol Share ---
    document.querySelectorAll('.share-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const url = this.dataset.url;
            const title = this.dataset.title;
            const shareData = { title: `Karya: ${title}`, text: `Lihat karya keren "${title}" di Kreatoria!`, url: url };
            try {
                if (navigator.share) {
                    await navigator.share(shareData);
                } else {
                    await navigator.clipboard.writeText(url);
                    alert('Link karya telah disalin ke clipboard!');
                }
            } catch (err) {
                console.error("Error sharing:", err);
            }
        });
    });
});
</script>
@endpush
