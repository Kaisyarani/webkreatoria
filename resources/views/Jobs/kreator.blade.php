@extends('layouts.app')

@section('title', 'Lowongan Terbaru - Kreatoria')

@push('styles')
<style>
    /* CSS Khusus untuk halaman jobs kreator */
    main {
            margin-top: var(--navbar-height);
        }

    .page-header { text-align: center; padding: 60px 20px; background-color: var(--bg-medium); }
    .page-header h1 { font-size: 48px; }
    .page-header p { font-size: 18px; color: var(--text-secondary); max-width: 600px; margin: 10px auto 0; }
    .job-card { background-color: var(--bg-medium); border-radius: 12px; padding: 25px; margin-bottom: 20px; border: 1px solid var(--bg-light); }
    .job-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; }
    .job-card-title { font-size: 22px; }
    .job-card-company { font-size: 16px; color: var(--text-secondary); margin-top: 5px; }
    .job-tags { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
    .job-tag { background-color: var(--bg-light); color: var(--text-secondary); font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px; }
    .job-card-description { color: var(--text-secondary); line-height: 1.7; }
    .nav-button-primary { background-color: var(--accent); color: var(--bg-dark); padding: 8px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; }
    .footer { border-top:1px solid var(--bg-light); text-align:center; padding:40px 0; margin-top: 40px; }
    .container { width: 90%; max-width: 1200px; margin: 0 auto; padding: 40px 0; }
</style>
@endpush

@section('content')
    <header class="page-header">
        <h1>Temukan Peluang Karir Impianmu</h1>
        <p>Jelajahi ratusan lowongan pekerjaan dari perusahaan terkemuka yang mencari talenta kreatif sepertimu.</p>
    </header>
    <div class="container">
        <div id="job-list-container">
            @forelse ($jobs as $job)
                <div class="job-card">
                    <div class="job-card-header">
                        <div>
                            <h2 class="job-card-title">{{ $job->title }}</h2>
                            <p class="job-card-company">{{ $job->user->name }} • {{ $job->location }}</p>
                        </div>
                        <a href="#" class="nav-button-primary">Lihat Detail</a>
                    </div>
                    <div class="job-tags">
                        <span class="job-tag">{{ $job->type }}</span>
                        @foreach ($job->tags as $tag)
                            <span class="job-tag">{{ $tag }}</span>
                        @endforeach
                        @if($job->deadline)
                            <span class="job-tag" style="background-color: #0E7490; color: var(--text-primary);">Tenggat: {{ $job->deadline->format('d M Y') }}</span>
                        @endif
                    </div>
                    <p class="job-card-description">{{ Str::limit($job->description, 200) }}</p>
                </div>
            @empty
                <p style="text-align: center; color: var(--text-secondary);">Saat ini belum ada lowongan yang tersedia.</p>
            @endforelse
        </div>
    </div>
@endsection
