@extends('layouts.app')

@section('title', 'Eksplorasi Talenta - Kreatoria')

@push('styles')
<style>
    /* Mengambil semua CSS dari eksplor-loggedin.html */
    body {
        padding-top: var(--navbar-height, 88px);
    }
    .container { width: 90%; max-width: 1200px; margin: 0 auto; padding: 40px 0; }
    .page-header { text-align: center; padding: 60px 20px 40px; }
    .page-header h1 { font-size: 48px; }
    .page-header p { font-size: 18px; color: var(--text-secondary); max-width: 700px; margin: 10px auto 0; }
    .ai-cta-section { margin-top: 40px; padding: 30px; background-image: linear-gradient(45deg, #0E7490, var(--bg-medium) 70%); border-radius: 12px; text-align: center; }
    .ai-cta-section .tagline { font-size: 22px; font-weight: 700; display: block; margin-bottom: 15px; }
    .btn-ai-cta { padding: 12px 30px; border-radius: 8px; font-weight: 700; font-size: 16px; display: inline-flex; align-items: center; gap: 10px; background-color: var(--accent); color: var(--bg-dark); text-decoration: none; border: none; cursor: pointer; }

    .filter-controls { background-color: var(--bg-medium); padding: 30px; border-radius: 12px; margin-bottom: 50px; }
    .top-filters { display: grid; grid-template-columns: 2fr auto auto; gap: 15px; margin-bottom: 20px; align-items: center; }
    .search-bar-wrapper { position: relative; width: 100%; }
    #search-bar { width: 100%; padding: 14px 20px 14px 45px; background-color: var(--bg-dark); border: 1px solid var(--bg-light); border-radius: 8px; color: var(--text-primary); font-size: 16px; }
    .search-bar-wrapper .icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); }
    .filter-toggle, .filter-reset { padding: 10px 16px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; }
    .filter-toggle { background-color: var(--accent); color: var(--bg-dark); }
    .filter-reset { background-color: transparent; color: var(--text-secondary); border: 1px solid var(--bg-light); }
    .role-filters { display: none; } /* Default tersembunyi */
    .role-filters.visible { display: flex; gap: 15px; flex-wrap: wrap; padding-top: 20px; border-top: 1px solid var(--bg-light); margin-top: 20px; }
    .role-filters label { display: block; background-color: var(--bg-light); padding: 8px 18px; border-radius: 20px; cursor: pointer; transition: all 0.2s ease; user-select: none; }
    .role-filters input[type="checkbox"] { display: none; }
    .role-filters input[type="checkbox"]:checked + label { background-color: var(--accent); color: var(--bg-dark); font-weight: 700; }

    .talent-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; }
    .talent-card { background-color: var(--bg-medium); padding: 25px; border-radius: 12px; text-align: center; transition: all 0.3s ease; text-decoration: none; color: var(--text-primary); }
    .talent-card:hover { transform: translateY(-5px); background-color: var(--bg-light); }
    .talent-card img { width: 100px; height: 100px; border-radius: 50%; margin-bottom: 15px; border: 3px solid var(--bg-light); object-fit: cover; }
    .talent-card h3 { font-size: 20px; }
    .talent-card p { color: var(--text-secondary); font-size: 14px; margin-top: 4px; }
     .talent-card .talent-details {
        margin-top: 15px;
        font-size: 14px;
    }
    .talent-card .talent-role {
        display: inline-block;
        background-color: var(--accent);
        color: var(--bg-dark);
        padding: 4px 12px;
        border-radius: 15px;
        font-weight: 700;
    }
</style>
@endpush

@section('content')
<header class="page-header">
    <h1>Eksplorasi Talenta</h1>
    <p>Cari, filter, dan temukan talenta yang paling sesuai dengan kebutuhan Anda.</p>

    <div class="ai-cta-section">
        <span class="tagline">Lewati pencarian manual. Dapatkan rekomendasi instan dari AI.</span>
        <a href="{{ route('explore.ai-assistant') }}" class="btn-ai-cta">
            <i class="fas fa-magic"></i>
            <span>Gunakan Asisten Talenta</span>
        </a>
    </div>
</header>
<div class="container">
    <div class="filter-controls">
        <div class="top-filters">
            <div class="search-bar-wrapper">
                <span class="icon"><i class="fas fa-search"></i></span>
                <input type="search" id="search-bar" placeholder="Cari berdasarkan nama atau keahlian...">
            </div>
            <button class="filter-toggle" id="toggle-role-filters"><i class="fas fa-sliders-h"></i> Pilih Role</button>
            <button class="filter-reset" id="reset-filters"><i class="fas fa-times-circle"></i> Reset</button>
        </div>
        <div class="role-filters" id="role-filters">
            {{-- Role akan di-generate secara dinamis jika perlu, atau bisa hardcode --}}
            <input type="checkbox" id="role-uiux" name="role" value="UI/UX Designer"><label for="role-uiux">UI/UX Designer</label>
            <input type="checkbox" id="role-frontend" name="role" value="Frontend Developer"><label for="role-frontend">Frontend Developer</label>
            <input type="checkbox" id="role-branding" name="role" value="Branding"><label for="role-branding">Branding</label>
            <input type="checkbox" id="role-ilustrator" name="role" value="Ilustrator"><label for="role-ilustrator">Ilustrator</label>
        </div>
    </div>
    <div class="talent-grid" id="talent-grid-container">
        {{-- Konten talenta akan dirender oleh JavaScript --}}
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Mengambil data talenta secara dinamis dari controller Laravel
    const allTalents = @json($talents);

    const talentGrid = document.getElementById('talent-grid-container');
    const searchBar = document.getElementById('search-bar');
    const roleFiltersContainer = document.getElementById('role-filters');
    const roleCheckboxes = roleFiltersContainer.querySelectorAll('input[name="role"]');

    function renderTalents(data) {
        if (!talentGrid) return;
        if (data.length === 0) {
            talentGrid.innerHTML = '<p style="color: var(--text-secondary); text-align: center; grid-column: 1 / -1;">Talenta tidak ditemukan.</p>';
            return;
        }

        talentGrid.innerHTML = data.map(talent => {
            const profile = talent.kreator_profile || {};
            const photoUrl = profile.photo ? `{{ asset('storage') }}/${profile.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(talent.name)}&background=22D3EE&color=111827&bold=true`;
            const profileUrl = `{{ url('/profile') }}/${talent.id}`;
            const title = profile.title || 'Kreator';

             return `
            <a href="${profileUrl}" class="talent-card" data-name="${talent.name.toLowerCase()}" data-title="${title.toLowerCase()}">
                <img src="${photoUrl}" alt="${talent.name}">
                <h3>${talent.name}</h3>
                <p>${talent.email}</p>
                <div class="talent-details">
                    <span class="talent-role">${title}</span>
                </div>
            </a>`;
        }).join('');
    }

    function filterAndRender() {
        const searchTerm = searchBar.value.toLowerCase();
        const selectedRoles = Array.from(roleCheckboxes)
                                  .filter(cb => cb.checked)
                                  .map(cb => cb.value.toLowerCase());

        const filtered = allTalents.filter(talent => {
            const profile = talent.kreator_profile || {};
            const nameMatch = talent.name.toLowerCase().includes(searchTerm);
            const titleMatch = (profile.title || '').toLowerCase().includes(searchTerm);
            const skills = (profile.skills || []).join(' ').toLowerCase();
            const skillsMatch = skills.includes(searchTerm);

            const searchMatch = nameMatch || titleMatch || skillsMatch;
            const roleMatch = selectedRoles.length === 0 || selectedRoles.includes((profile.title || '').toLowerCase());

            return searchMatch && roleMatch;
        });

        renderTalents(filtered);
    }

    if (searchBar) {
        searchBar.addEventListener('input', filterAndRender);
    }
    roleCheckboxes.forEach(cb => cb.addEventListener('change', filterAndRender));

    const toggleBtn = document.getElementById('toggle-role-filters');
    if (toggleBtn && roleFiltersContainer) {
        toggleBtn.addEventListener('click', () => {
            roleFiltersContainer.classList.toggle('visible');
        });
    }

    const resetBtn = document.getElementById('reset-filters');
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            if (searchBar) searchBar.value = '';
            roleCheckboxes.forEach(cb => cb.checked = false);
            if (roleFiltersContainer) roleFiltersContainer.classList.remove('visible');
            renderTalents(allTalents);
        });
    }

    // Render awal saat halaman dimuat
    renderTalents(allTalents);
});
</script>
@endpush
