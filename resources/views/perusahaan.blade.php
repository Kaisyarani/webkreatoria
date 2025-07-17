@extends('layouts.app')

@section('title', 'Dashboard Perusahaan')

@push('styles')
<style>
    /* CSS Khusus untuk halaman ini */
    main {
            margin-top: var(--navbar-height);
        }

    .hero-section{min-height: calc(100vh - 88px); display:flex;align-items:center;text-align:center;background:radial-gradient(circle at 20% 80%,rgba(34,211,238,.1),transparent 30%),radial-gradient(circle at 80% 30%,rgba(14,116,144,.15),transparent 30%),var(--bg-dark)}.hero-content{max-width:800px;margin:0 auto;padding-top:0}.hero-section h1{font-size:56px;line-height:1.3;margin-bottom:20px}.hero-section .highlight{color:var(--accent)}.animated-text-container{display:inline-block;position:relative;vertical-align:top;height:60px;overflow:hidden;text-align:left;transition:width .3s ease}.animated-text-item{position:absolute;left:0;opacity:0;transform:translateY(100%);transition:transform .6s ease,opacity .6s ease;white-space:nowrap}.animated-text-item.active{opacity:1;transform:translateY(0)}.animated-text-item.leaving{transform:translateY(-100%)}.hero-section p{font-size:18px;color:var(--text-secondary);margin-bottom:40px}.cta-button{display:inline-block;padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:700;transition:all .3s ease}.cta-primary{background-color:var(--accent);color:var(--bg-dark)}.cta-secondary{background-color:transparent;color:var(--text-primary);border:2px solid var(--bg-light);margin-left:15px}
    .community-feed-section h2, .showcase-section h2 { text-align: center; font-size: 40px; margin-bottom: 50px; }
    .post-feed-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; }
    .community-post-card { background-color: var(--bg-medium); padding: 25px; border-radius: 12px; border: 1px solid var(--bg-light); }
    .post-header { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
    .post-author-img { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; }
    .post-author-info .name { font-weight: 700; font-size: 16px; }
    .post-author-info .time { font-size: 13px; color: var(--text-secondary); }
    .post-text { color: var(--text-secondary); line-height: 1.7; margin-bottom: 20px; }
    .post-footer { display: flex; gap: 25px; padding-top: 15px; border-top: 1px solid var(--bg-light); margin-top: 20px; color: var(--text-secondary); font-size: 14px; }
    .post-footer span i { margin-right: 8px; }
    .project-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:25px}.project-card{background-color:var(--bg-medium);border-radius:12px;overflow:hidden;transition:transform .3s ease}.project-card img{width:100%;height:220px;object-fit:cover}.project-card-content{padding:20px}.project-card h3{font-size:20px;margin-bottom:10px}.project-card p{color:var(--text-secondary);font-size:14px}
    .footer{border-top:1px solid var(--bg-light);text-align:center;padding:40px 0}
</style>
@endpush

@section('content')
    <section class="hero-section">
        <div class="hero-content">
            <h1>Temukan Talenta Terbaik. <br> Lihat <span class="highlight animated-text-container"><span class="animated-text-item active">Proses Berpikir</span><span class="animated-text-item">Evolusi Proyek</span><span class="animated-text-item">Gaya Kolaborasi</span></span> Mereka.</h1>
            <p>Rekrut talenta berdasarkan bukti nyata dari proses kerja mereka, bukan hanya dari CV atau portofolio yang sudah jadi.</p>
            <a href="{{ route('jobs.create') }}" class="cta-button cta-primary">Posting Pekerjaan</a>
            <a href="{{ route('profile.edit') }}" class="cta-button cta-secondary">Lengkapi Profil Perusahaan</a>
        </div>
    </section>

    <div class="container">
        <section class="community-feed-section">
            <h2>Aktivitas Terbaru dari Para Kreator</h2>
            <div class="post-feed-grid" id="community-post-feed">
                <p style="color: var(--text-secondary); text-align: center; grid-column: 1 / -1;">Belum ada aktivitas terbaru dari kreator.</p>
            </div>
        </section>

        <section class="showcase-section" style="padding-top: 80px;">
            <h2>Sorotan Proyek</h2>
            <div class="project-grid">
                <div class="project-card"><img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?q=80&w=2070" alt="Proyek 1"><div class="project-card-content"><h3>Aplikasi Mobile FinTech</h3><p>Oleh: Clara Wijaya</p></div></div>
                <div class="project-card"><img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070" alt="Proyek 2"><div class="project-card-content"><h3>Redesain Dashboard SaaS</h3><p>Oleh: David Lee</p></div></div>
                <div class="project-card"><img src="https://images.unsplash.com/photo-1604399727149-8b21c43f3832?q=80&w=1974" alt="Proyek 3"><div class="project-card-content"><h3>Brand Identity untuk Startup Kopi</h3><p>Oleh: Rina Agustina</p></div></div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
     document.addEventListener('DOMContentLoaded', function() {
            // Script untuk hamburger menu
            const hamburger = document.querySelector('.hamburger-menu');
            const navMenu = document.querySelector('.navbar-menu');
            if (hamburger && navMenu) {
                hamburger.addEventListener('click', () => {
                    hamburger.classList.toggle('active');
                    navMenu.classList.toggle('active');
                });
            }

            // Script untuk dropdown menu profile
            const profileBtn = document.querySelector('.profile-btn');
            const dropdownMenu = document.querySelector('.dropdown-menu');
            if (profileBtn && dropdownMenu) {
                profileBtn.addEventListener('click', (e) => {
                    e.stopPropagation(); // Mencegah event menyebar ke window
                    dropdownMenu.classList.toggle('show');
                });

                window.addEventListener('click', function(e) {
                    if (!profileBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.remove('show');
                    }
                });
            }

            // SCRIPT UNTUK MENAMPILKAN FEED POSTINGAN
            const postFeedContainer = document.getElementById('community-post-feed');
            const allPosts = JSON.parse(localStorage.getItem('kreatoriaPosts')) || [];

            if (allPosts.length === 0) {
                postFeedContainer.innerHTML = '<p style="color: var(--text-secondary); text-align: center; grid-column: 1 / -1;">Belum ada aktivitas terbaru dari kreator.</p>';
            } else {
                const latestPosts = allPosts.slice(0, 4);

                latestPosts.forEach(post => {
                    const postCardHTML = `
                    <div class="community-post-card">
                        <div class="post-header">
                            <img src="https://i.pravatar.cc/50?u=${post.author.replace(/\s/g, '')}" alt="Author" class="post-author-img">
                            <div class="post-author-info">
                                <div class="name">${post.author}</div>
                                <div class="time">${new Date(post.timestamp).toLocaleDateString('id-ID', {day: 'numeric', month: 'long'})}</div>
                            </div>
                        </div>
                        <p class="post-text">${post.text.substring(0, 150)}${post.text.length > 150 ? '...' : ''}</p>
                        <div class="post-footer">
                            <span><i class="far fa-heart"></i> ${Math.floor(Math.random() * 100)}</span>
                            <span><i class="far fa-comment"></i> ${Math.floor(Math.random() * 20)}</span>
                            <span><i class="fas fa-share-alt"></i></span>
                        </div>
                    </div>
                    `;
                    postFeedContainer.insertAdjacentHTML('beforeend', postCardHTML);
                });
            }
        });
</script>
@endpush
