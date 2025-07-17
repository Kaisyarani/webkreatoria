@extends('layouts.app')

@section('title', 'Dashboard Kreator')

@push('styles')
<style>
    /* CSS Khusus untuk halaman ini */
   main {
            padding-top: var(--navbar-height);
   }
    .container { width: 90%; max-width: 1200px; margin: 0 auto; padding: 80px 0; }
        h1, h2, h3 { font-weight: 800; }
    .hero-section{min-height: 100vh; display:flex;align-items:center;text-align:center;background:radial-gradient(circle at 20% 80%,rgba(34,211,238,.1),transparent 30%),radial-gradient(circle at 80% 30%,rgba(14,116,144,.15),transparent 30%),var(--bg-dark)}.hero-content{max-width:800px;margin:0 auto;padding-top:0}.hero-section h1{font-size:56px;line-height:1.3;margin-bottom:20px}.hero-section .highlight{color:var(--accent)}.animated-text-container{display:inline-block;position:relative;vertical-align:top;height:60px;overflow:hidden;text-align:left;transition:width .3s ease}.animated-text-item{position:absolute;left:0;opacity:0;transform:translateY(100%);transition:transform .6s ease,opacity .6s ease;white-space:nowrap}.animated-text-item.active{opacity:1;transform:translateY(0)}.animated-text-item.leaving{transform:translateY(-100%)}.hero-section p{font-size:18px;color:var(--text-secondary);margin-bottom:40px}.cta-button{display:inline-block;padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:700;transition:all .3s ease}.cta-primary{background-color:var(--accent);color:var(--bg-dark)}.cta-secondary{background-color:transparent;color:var(--text-primary);border:2px solid var(--bg-light);margin-left:15px}
    .showcase-section h2 { text-align: center; font-size: 40px; margin-bottom: 50px; }
    .project-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 25px; }
    .project-card { background-color: var(--bg-medium); border-radius: 12px; overflow: hidden; }
    .project-card img { width: 100%; height: 220px; object-fit: cover; }
    .project-card-content { padding: 20px; }
    .project-card h3 { font-size: 20px; margin-bottom: 10px; }
    .project-card p { color: var(--text-secondary); font-size: 14px; }
    .showcase-cta { text-align: center; margin-top: 50px; }
    .company-section{background-color:var(--bg-medium);text-align:center;padding:80px 5%;border-radius:20px; margin-top: 80px;}.company-section h2{font-size:40px;margin-bottom:15px}.company-section p{color:var(--text-secondary);max-width:600px;margin:0 auto 30px auto}
    .footer{border-top:1px solid var(--bg-light);text-align:center;padding:40px 0}
</style>
@endpush

@section('content')
    <section class="hero-section">
        <div class="hero-content">
            <h1>Bukan Sekadar Portofolio. <br> Ini <span class="highlight animated-text-container"><span class="animated-text-item active">Jurnal Perjalanan</span><span class="animated-text-item">Cerita Proses</span><span class="animated-text-item">Ruang Kolaborasi</span><span class="animated-text-item">Panggung Evolusi</span></span> Karyamu.</h1>
            <p>Platform untuk kreator, developer, dan desainer mendokumentasikan proses, berkolaborasi dalam proyek, dan mengubah ide menjadi peluang.</p>
            <a href="{{ route('posts.create') }}" class="cta-button cta-primary">Mulai Proyek Baru</a>
            <a href="{{ route('profile.edit') }}" class="cta-button cta-secondary">Lengkapi Profilmu</a>
        </div>
    </section>

    <div class="container">
        <section class="showcase-section">
            <h2>Karya Terbaru dari Komunitas</h2>
            <div class="project-grid">
               <p style="color: var(--text-secondary); text-align: center;">Belum ada karya untuk ditampilkan.</p>
            </div>
            <div class="showcase-cta">
                 <a href="{{ route('gallery.index') }}" class="cta-button cta-secondary" style="margin-left: 0;">Lihat Semua Karya</a>
            </div>
        </section>
    </div>

    <section class="company-section">
        <h2>Temukan Talenta di Balik Karya</h2>
        <p>Akses ke proses pemecahan masalah talenta, bukan hanya hasil akhirnya. Rekrut individu proaktif yang terbukti bisa membangun dan berkolaborasi.</p>
        <a href="{{ route('explore.index') }}" class="cta-button cta-primary">Jelajahi Talenta</a>
    </section>
@endsection

@push('scripts')
 <script src="auth.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script untuk hamburger menu & animasi teks
            // ... (kode dari sebelumnya)

            // Fungsi untuk memuat postingan terbaru dari localStorage
            function loadLatestPosts() {
                const projectGrid = document.querySelector('.project-grid');
                const allPosts = JSON.parse(localStorage.getItem('kreatoriaPosts')) || [];

                const latestPosts = allPosts.slice(0, 3);

                if (latestPosts.length > 0) {
                    projectGrid.innerHTML = '';
                    latestPosts.forEach(post => {
                        const postCardHTML = `
                        <div class="project-card">
                            <img src="${post.image}" alt="Gambar Postingan">
                            <div class="project-card-content">
                                <h3>${post.text.substring(0, 40)}${post.text.length > 40 ? '...' : ''}</h3>
                                <p>Oleh: ${post.author}</p>
                            </div>
                        </div>
                        `;
                        projectGrid.insertAdjacentHTML('beforeend', postCardHTML);
                    });
                } else {
                    projectGrid.innerHTML = '<p style="color: var(--text-secondary); text-align: center;">Belum ada karya untuk ditampilkan. Buat postingan di profilmu!</p>';
                }
            }

            loadLatestPosts();
        });
    </script>
@endpush
