{{-- Kode ini berisi filter dan grid yang bisa digunakan di semua halaman galeri --}}
<style>
    .filter-btn { background-color: var(--bg-medium); color: var(--text-secondary); border: 1px solid var(--bg-light); padding: 10px 22px; border-radius: 30px; cursor: pointer; font-weight: 600; transition: all 0.3s ease; }
    .filter-btn:hover { background-color: var(--bg-light); color: var(--text-primary); }
</style>
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
    </div>
</div>

<div class="project-grid">
    @forelse ($posts as $post)
        <div class="project-card" data-category="{{ $post->category }}">
            <a href="#">
                <img class="project-card-image" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
            </a>
            <div class="project-card-content">
                <h3>{{ $post->title }}</h3>
                <p>Oleh: <a href="{{ route('profile.show', $post->user) }}" style="color: var(--accent); text-decoration: none;">{{ $post->user->name }}</a></p>
            </div>
        </div>
    @empty
        <p style="color: var(--text-secondary); text-align: center; grid-column: 1 / -1;">
            Belum ada karya untuk ditampilkan saat ini.
        </p>
    @endforelse
</div>

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
