@extends('layouts.app')

@section('title', 'Kreatoria - Jurnal Perjalanan Karyamu')

@push('styles')
<style>
    /* CSS KHUSUS UNTUK HALAMAN INI */
    main {
            margin-top: var(--navbar-height);
        }

    /* === HALAMAN WELCOME / SPLASH SCREEN === */
        @keyframes typing { from { width: 0; } to { width: 100%; } }
        @keyframes blink-caret { from, to { border-color: transparent; } 50% { border-color: var(--accent); } }

        .splash-screen {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: var(--bg-dark); z-index: 200; display: flex;
            align-items: center; justify-content: center; transition: opacity 1s ease-in-out;
        }
        .splash-logo-container {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            transition: top 1.5s cubic-bezier(0.77, 0, 0.175, 1),
                        left 1.5s cubic-bezier(0.77, 0, 0.175, 1),
                        transform 1.5s cubic-bezier(0.77, 0, 0.175, 1);
        }
        .splash-logo {
            font-size: 48px; font-weight: 800; color: var(--text-primary);
            overflow: hidden; border-right: .15em solid var(--accent); white-space: nowrap;
            margin: 0 auto; letter-spacing: .1em;
            animation: typing 2s steps(9, end), blink-caret .75s step-end infinite;
            transition: font-size 1.5s cubic-bezier(0.77, 0, 0.175, 1),
                        letter-spacing 1.5s cubic-bezier(0.77, 0, 0.175, 1);
        }
        .splash-screen.active .splash-logo-container {
            top: calc(var(--navbar-height) / 2); left: 5%;
            transform: translate(0, -50%);
        }
        .splash-screen.active .splash-logo {
             font-size: 24px; animation: none; border-right: none; letter-spacing: normal;
        }
        .splash-screen.hidden { opacity: 0; pointer-events: none; display: none; }
        #main-content { opacity: 0; transition: opacity 1s ease-in-out; }
        #main-content.visible { opacity: 1; }

    .hero-section{min-height: calc(100vh - 88px); display:flex;align-items:center;text-align:center;background:radial-gradient(circle at 20% 80%,rgba(34,211,238,.1),transparent 30%),radial-gradient(circle at 80% 30%,rgba(14,116,144,.15),transparent 30%),var(--bg-dark)}.hero-content{max-width:800px;margin:0 auto;padding-top:0}.hero-section h1{font-size:56px;line-height:1.3;margin-bottom:20px}.hero-section .highlight{color:var(--accent)}.animated-text-container{display:inline-block;position:relative;vertical-align:top;height:60px;overflow:hidden;text-align:left;transition:width .3s ease}.animated-text-item{position:absolute;left:0;opacity:0;transform:translateY(100%);transition:transform .6s ease,opacity .6s ease;white-space:nowrap}.animated-text-item.active{opacity:1;transform:translateY(0)}.animated-text-item.leaving{transform:translateY(-100%)}.hero-section p{font-size:18px;color:var(--text-secondary);margin-bottom:40px}.cta-button{display:inline-block;padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:700;transition:all .3s ease}.cta-primary{background-color:var(--accent);color:var(--bg-dark)}.cta-secondary{background-color:transparent;color:var(--text-primary);border:2px solid var(--bg-light);margin-left:15px}.feature-item{display:flex;align-items:center;gap:60px;margin-bottom:100px}.feature-item:nth-child(even){flex-direction:row-reverse}.feature-visual{flex:1;background-color:var(--bg-medium);height:350px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:24px;color:var(--text-secondary)}.feature-text{flex:1}.feature-text h2{font-size:36px;margin-bottom:15px}.feature-text p{font-size:16px;color:var(--text-secondary);line-height:1.7}.showcase-section h2{text-align:center;font-size:40px;margin-bottom:50px}.project-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:25px}.project-card{background-color:var(--bg-medium);border-radius:12px;overflow:hidden;transition:transform .3s ease}.project-card img{width:100%;height:220px;object-fit:cover}.project-card-content{padding:20px}.project-card h3{font-size:20px;margin-bottom:10px}.project-card p{color:var(--text-secondary);font-size:14px}.company-section{background-color:var(--bg-medium);text-align:center;padding:80px 5%;border-radius:20px}.company-section h2{font-size:40px;margin-bottom:15px}.company-section p{color:var(--text-secondary);max-width:600px;margin:0 auto 30px auto}.footer{border-top:1px solid var(--bg-light);text-align:center;padding:40px 0}.footer p{color:var(--text-secondary);font-size:14px}
    .features-section { padding: 0 30px; }
    .feature-item { display: flex; align-items: center; gap: 40px; margin-bottom: 100px; flex-wrap: wrap; }
    .feature-visual { flex: 1; border-radius: 12px; overflow: hidden; }
    .feature-visual img { width: 100%; height: 100%; object-fit: cover; border-radius: 10px; }
    .feature-text { flex: 1; }
    .feature-text h2 { font-size: 36px; margin-bottom: 15px; }
    .feature-text p { font-size: 16px; color: var(--text-secondary); line-height: 1.7; }
    .footer{border-top:1px solid var(--bg-light);text-align:center;padding:40px 0}

</style>
@endpush

@section('content')

    <div class="splash-screen"><div class="splash-logo-container"><div class="splash-logo">Kreatoria</div></div></div>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Bukan Sekadar Portofolio. <br> Ini <span class="highlight animated-text-container"><span class="animated-text-item active">Jurnal Perjalanan</span><span class="animated-text-item">Cerita Proses</span><span class="animated-text-item">Ruang Kolaborasi</span><span class="animated-text-item">Panggung Evolusi</span></span> Karyamu.</h1>
            <p>Platform untuk kreator, developer, dan desainer mendokumentasikan proses, berkolaborasi dalam proyek, dan mengubah ide menjadi peluang.</p>
            <a href="{{ route('register') }}" class="cta-button cta-primary">Mulai Perjalananmu</a>
            <a href="{{ route('gallery.index') }}" class="cta-button cta-secondary">Lihat Karya Kreator →</a>
        </div>
    </section>
    <div class="container">
        <section class="features-section">
            <div class="feature-item">
                <div class="feature-visual">
                    <img src="{{ asset('images/2.jpg') }}" alt="Visual Timeline Proyek">
                </div>
                <div class="feature-text">
                    <h2>Dokumentasikan Setiap Evolusi.</h2>
                    <p>Unggah sketsa, code snippet, desain, hingga catatan rapat. Biarkan dunia melihat proses brilian di balik setiap karya besar Anda.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-visual">
                    <img src="{{ asset('images/1.jpg') }}" alt="Visual Koneksi Kolaborasi">
                </div>
                <div class="feature-text">
                    <h2>Temukan Sinergi Kolaborasi.</h2>
                    <p>Cari talenta dengan keahlian spesifik. Ajak mereka bergabung dalam proyek Anda atau tawarkan diri untuk menjadi bagian dari sebuah ide besar.</p>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
     document.addEventListener('DOMContentLoaded', function() {

        // --- SCRIPT UTAMA DENGAN LOGIKA SESSIONSTORAGE ---
        const splashScreen = document.querySelector('.splash-screen');
        const mainContent = document.querySelector('#main-content');
        const mainLogo = document.querySelector('.navbar .logo');

        const runSplashAnimation = () => {
            sessionStorage.setItem('splashSeen', 'true');
            setTimeout(() => { splashScreen.classList.add('active'); }, 2500);
            setTimeout(() => { mainContent.classList.add('visible'); }, 3500);
            setTimeout(() => {
                splashScreen.classList.add('hidden');
                mainLogo.style.opacity = '1';
            }, 4100);
            setTimeout(() => { if (splashScreen) { splashScreen.style.display = 'none'; } }, 5100);
        };

        const skipSplashAnimation = () => {
            if (splashScreen) { splashScreen.style.display = 'none'; }
            mainContent.classList.add('visible');
            mainLogo.style.opacity = '1';
        };

        if (sessionStorage.getItem('splashSeen') === 'true') {
            skipSplashAnimation();
        } else {
            runSplashAnimation();
        }

        // --- Script untuk Navbar Responsif (Hamburger) ---
        const hamburger = document.querySelector('.hamburger-menu');
        const navMenu = document.querySelector('.navbar-menu');
        if (hamburger && navMenu) {
            hamburger.addEventListener('click', () => {
                hamburger.classList.toggle('active');
                navMenu.classList.toggle('active');
            });
        }

        // --- Script untuk Animasi Teks di Hero Section (KODE YANG HILANG DIKEMBALIKAN) ---
        const textContainer = document.querySelector('.animated-text-container');
        if (textContainer) {
            const textItems = document.querySelectorAll('.animated-text-item');
            let currentIndex = 0;
            const intervalTime = 3000;

            function animateText() {
                const currentItem = textItems[currentIndex];
                const nextIndex = (currentIndex + 1) % textItems.length;
                const nextItem = textItems[nextIndex];

                if (nextItem) {
                    textContainer.style.width = nextItem.offsetWidth + 'px';
                }

                if (currentItem) {
                    currentItem.classList.add('leaving');
                    currentItem.classList.remove('active');
                }

                if (nextItem) {
                    nextItem.classList.add('active');
                }

                setTimeout(() => {
                    if (currentItem) {
                        currentItem.classList.remove('leaving');
                    }
                }, 600);

                currentIndex = nextIndex;
            }

            if (textItems.length > 0) {
                textContainer.style.width = textItems[0].offsetWidth + 'px';
                setInterval(animateText, intervalTime);
            }
        }
    });
</script>
@endpush
