@extends('layouts.app')

@section('title', 'Gallery Karya - Kreatoria')

@push('styles')
<style>
     main {
            margin-top: var(--navbar-height);
        }
    .container { width: 90%; max-width: 1200px; margin: 0 auto; padding: 10px 0; }
    .page-header { text-align: center; padding: 60px 20px; }
    .page-header h1 { font-size: 48px; margin-bottom: 10px; }
    .page-header p { font-size: 18px; color: var(--text-secondary); max-width: 600px; margin: 0 auto; }
    .gallery-controls { display: flex; flex-direction: column; gap: 30px; margin-bottom: 50px; align-items: center; }
    .search-wrapper { position: relative; width: 100%; max-width: 500px; }
    #search-bar { width: 100%; padding: 14px 50px; background-color: var(--bg-medium); border: 1px solid var(--bg-light); border-radius: 8px; color: var(--text-primary); font-size: 16px; }
    .search-wrapper .icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); }
    .filter-bar { display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; }
    .filter-btn { background-color: var(--bg-medium); color: var(--text-secondary); border: 1px solid var(--bg-light); padding: 10px 22px; border-radius: 30px; cursor: pointer; font-weight: 600; transition: all 0.3s ease; }
    .filter-btn:hover { background-color: var(--bg-light); color: var(--text-primary); }
    .filter-btn.active { background-color: var(--accent); color: var(--bg-dark); border-color: var(--accent); }
    .project-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 25px; }
    .project-card { background-color: var(--bg-medium); border-radius: 12px; overflow: hidden; transition: transform 0.3s, opacity 0.4s ease; }
    .project-card.hidden { transform: scale(0.9); opacity: 0; display: none; }
    .project-card:hover { transform: translateY(-8px); }
    .project-card img { width: 100%; height: 220px; object-fit: cover; }
    .project-card-content { padding: 20px; }
    .project-card h3 { font-size: 20px; margin-bottom: 10px; }
    .project-card p { color: var(--text-secondary); font-size: 14px; }
</style>
@endpush

@section('content')
<header class="page-header">
    <h1>Eksplorasi Karya Mengagumkan</h1>
    <p>Temukan inspirasi dari ribuan karya yang dibuat oleh para talenta terbaik di komunitas Kreatoria.</p>
</header>
<div class="container">
    <div class="gallery-controls">
        <div class="search-wrapper">
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </span>
            <input type="text" id="search-bar" placeholder="Cari berdasarkan judul atau kreator...">
        </div>
        <div class="filter-bar">
            <button class="filter-btn active" data-filter="all">Semua</button>
            <button class="filter-btn" data-filter="ui-ux">UI/UX Design</button>
            <button class="filter-btn" data-filter="branding">Branding</button>
            <button class="filter-btn" data-filter="ilustrasi">Ilustrasi</button>
            <button class="filter-btn" data-filter="web-dev">Web Development</button>
            <button class="filter-btn" data-filter="motion">Motion Design</button>
        </div>
    </div>

    <div class="project-grid">
        {{-- Contoh data statis, idealnya ini dari controller --}}
        <div class="project-card" data-category="web-dev">
            <img src="https://images.unsplash.com/photo-1555949963-ff9fe0c870eb?q=80&w=2070" alt="Proyek Web Dev">
            <div class="project-card-content"><h3>Portfolio Website Developer</h3><p>Oleh: Budi Santoso</p></div>
        </div>
        <div class="project-card" data-category="ui-ux">
            <img src="https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?q=80&w=2070" alt="Proyek UI/UX">
            <div class="project-card-content"><h3>Desain Ulang Aplikasi Musik</h3><p>Oleh: Citra Lestari</p></div>
        </div>
        <div class="project-card" data-category="ilustrasi">
            <img src="https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=1945" alt="Proyek Ilustrasi">
            <div class="project-card-content"><h3>Ilustrasi Karakter "Nusantara"</h3><p>Oleh: Dian Utami</p></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const searchBar = document.getElementById('search-bar');
    const projectCards = document.querySelectorAll('.project-card');

    function updateGallery() {
        const searchTerm = searchBar.value.toLowerCase();
        const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;

        projectCards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const author = card.querySelector('p').textContent.toLowerCase();
            const category = card.dataset.category;

            const matchesFilter = activeFilter === 'all' || category === activeFilter;
            const matchesSearch = title.includes(searchTerm) || author.includes(searchTerm);

            if (matchesFilter && matchesSearch) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.querySelector('.filter-btn.active').classList.remove('active');
            button.classList.add('active');
            updateGallery();
        });
    });

    if (searchBar) {
        searchBar.addEventListener('input', updateGallery);
    }
});
</script>
@endpush
