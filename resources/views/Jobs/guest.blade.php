@extends('layouts.app')

@section('title', 'Lowongan Kerja - Kreatoria')

@push('styles')
<style>
     main {
            margin-top: var(--navbar-height);
        }
    .container { width: 90%; max-width: 1200px; margin: 0 auto; padding: 40px 0; }
    .page-header { text-align: center; padding: 60px 0; background-color: var(--bg-medium); }
    .page-header h1 { font-size: 48px; margin-bottom: 10px; }
    .page-header p { font-size: 18px; color: var(--text-secondary); max-width: 600px; margin: 0 auto; }
    .job-card { background-color: var(--bg-medium); border-radius: 12px; padding: 25px; margin-bottom: 20px; border: 1px solid var(--bg-light); transition: border-color 0.3s ease, transform 0.3s ease; }
    .job-card:hover { border-color: var(--accent); transform: translateY(-5px); }
    .job-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;}
    .job-card-title { font-size: 22px; color: var(--text-primary); }
    .job-card-company { font-size: 16px; color: var(--text-secondary); margin-top: 5px; }
    .job-tags { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; }
    .job-tag { background-color: var(--bg-light); color: var(--text-secondary); font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px; }
    .job-card-description { color: var(--text-secondary); line-height: 1.7; }
    .nav-button-primary { background-color: var(--accent); color: var(--bg-dark); padding: 8px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; }
</style>
@endpush

@section('content')
<header class="page-header">
    <h1>Temukan Peluang Karir Kreatif Anda</h1>
    <p>Jelajahi ratusan lowongan kerja di bidang desain, pengembangan, penulisan, dan industri kreatif lainnya.</p>
</header>
<div class="container">
    @forelse ($jobs as $job)
        <div class="job-card">
            <div class="job-card-header">
                <div>
                    <h2 class="job-card-title">{{ $job->title }}</h2>
                    <p class="job-card-company">
                        <a href="{{ route('profile.show', $job->user) }}" style="color: var(--text-secondary); text-decoration: none;">
                            {{ $job->user->name }}
                        </a> • {{ $job->location }}
                    </p>
                </div>
                {{-- Tombol Lamar mengarahkan ke halaman login --}}
                <a href="{{ route('login') }}" class="nav-button nav-button-primary">Lamar</a>
            </div>
            <div class="job-tags">
                <span class="job-tag">{{ $job->type }}</span>
                @if(is_array($job->tags))
                    @foreach ($job->tags as $tag)
                        <span class="job-tag">{{ $tag }}</span>
                    @endforeach
                @endif
            </div>
            <p class="job-card-description">{{ Str::limit($job->description, 200) }}</p>
        </div>
    @empty
        <p style="text-align: center; color: var(--text-secondary);">Saat ini belum ada lowongan yang tersedia.</p>
    @endforelse
</div>
@endsection

@push('scripts')
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const jobListContainer = document.getElementById('job-list-container');
            const newlyPostedJob = JSON.parse(localStorage.getItem('newlyPostedJob'));

            // Fungsi untuk membuat kartu lowongan (tetap ada untuk menangani lowongan baru)
            function createJobCard(jobData) {
                const tagsHTML = jobData.tags.map(tag => `<span class="job-tag">${tag}</span>`).join('');

                const deadlineDate = new Date(jobData.deadline);
                const formattedDeadline = deadlineDate.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

                return `
                <div class="job-card">
                    <div class="job-card-header">
                        <div>
                            <h2 class="job-card-title">${jobData.title}</h2>
                            <p class="job-card-company">${jobData.company} • ${jobData.location}</p>
                        </div>
                        <a href="detail-pekerjaan.html" class="nav-button nav-button-primary">Lihat Detail</a>
                    </div>
                    <div class="job-tags">
                        <span class="job-tag">${jobData.type}</span>
                        ${tagsHTML}
                        <span class="job-tag" style="background-color: var(--accent-dark); color: var(--text-primary);">Tenggat: ${formattedDeadline}</span>
                    </div>
                    <p class="job-card-description">${jobData.description}</p>
                </div>
                `;
            }

            // Inisialisasi array kosong untuk semua lowongan
            let allJobs = [];

            // Jika ada lowongan baru dari localStorage, tambahkan ke array
            if (newlyPostedJob) {
                allJobs.push(newlyPostedJob);
            }

            // Hapus data lowongan statis
            // const staticJobs = [...];

            // Kosongkan kontainer terlebih dahulu
            jobListContainer.innerHTML = '';

            // Periksa apakah ada lowongan untuk ditampilkan
            if (allJobs.length > 0) {
                // Jika ada, tampilkan
                allJobs.forEach(job => {
                    jobListContainer.insertAdjacentHTML('beforeend', createJobCard(job));
                });
            } else {
                // Jika tidak ada, tampilkan pesan
                jobListContainer.innerHTML = '<p style="color: var(--text-secondary); text-align: center;">Saat ini belum ada lowongan yang tersedia.</p>';
            }
        });
    </script>
@endpush
