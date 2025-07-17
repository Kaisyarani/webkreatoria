@extends('layouts.app')

@section('title', 'Tentang Kami - Kreatoria')

@push('styles')
<style>
    main {
            margin-top: var(--navbar-height);
        }
    .container { width: 90%; max-width: 1000px; margin: 0 auto; padding: 60px 0; }
    h1, h2, h3 { font-weight: 800; }
    .about-header { text-align: center; margin-bottom: 80px; }
    .about-header h1 { font-size: 52px; margin-bottom: 15px; }
    .about-header .highlight { color: var(--accent); }
    .about-header p { font-size: 18px; color: var(--text-secondary); line-height: 1.7; max-width: 700px; margin: 0 auto; }
    .mission-section { display: flex; flex-wrap: wrap; align-items: center; gap: 60px; margin-bottom: 100px; }
    .mission-text { flex: 1; min-width: 300px; }
    .mission-text h2 { font-size: 36px; margin-bottom: 20px; }
    .mission-text p { color: var(--text-secondary); line-height: 1.8; }
    .mission-image { flex: 1; min-width: 300px; }
    .mission-image img { width: 100%; border-radius: 12px; }
    .team-section h2 { text-align: center; font-size: 40px; margin-bottom: 50px; }
    .team-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; }
    .team-card { background-color: var(--bg-medium); border-radius: 12px; padding: 30px; text-align: center; }
    .team-card img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 20px; border: 3px solid var(--bg-light); }
    .team-card h3 { font-size: 20px; margin-bottom: 5px; }
    .team-card p { color: var(--accent); font-weight: 500; }
</style>
@endpush

@section('content')
<div class="container">
    <header class="about-header">
        <h1>Kisah di Balik <span class="highlight">Kreatoria</span></h1>
        <p>Kami percaya bahwa setiap ide brilian layak mendapatkan panggung, dan setiap proses kreatif adalah cerita yang berharga. Kreatoria lahir dari semangat untuk memberdayakan para talenta kreatif di Indonesia.</p>
    </header>

    <section class="mission-section">
        <div class="mission-text">
            <h2>Misi Kami</h2>
            <p>Menjadi platform terdepan yang menghubungkan kreator dengan peluang, memungkinkan mereka untuk tidak hanya menampilkan hasil akhir, tetapi juga mendokumentasikan setiap langkah perjalanan kreatif mereka.</p>
        </div>
        <div class="mission-image">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2070" alt="Tim sedang berkolaborasi">
        </div>
    </section>

    <section class="team-section">
        <h2>Temui Tim Kami</h2>
        <div class="team-grid">
            <div class="team-card">
                <img src="{{ asset('images/avril.jpeg') }}" alt="Foto anggota tim 1">
                <h3>Avril</h3>
                <p>FrontEnd</p>
            </div>
            <div class="team-card">
                <img src="{{ asset('images/Kaisyarani22_DESMED.png') }}" alt="Foto anggota tim 2">
                <h3>Kai</h3>
                <p>Lead Developer</p>
            </div>
            <div class="team-card">
                <img src="{{ asset('images/foto diri.jpg') }}" alt="Foto anggota tim 3">
                <h3>Rayn</h3>
                <p>BackEnd</p>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger-menu');
            const navMenu = document.querySelector('.navbar-menu');
            if (hamburger && navMenu) {
                hamburger.addEventListener('click', () => {
                    hamburger.classList.toggle('active');
                    navMenu.classList.toggle('active');
                });
            }
        });
    </script>
@endpush
