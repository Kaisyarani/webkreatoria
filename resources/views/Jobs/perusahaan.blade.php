@extends('layouts.app')

@section('title', 'Manajemen Lowongan - Kreatoria')

@push('styles')
<style>
    /* CSS spesifik untuk halaman ini */
    main {
            margin-top: var(--navbar-height);
        }
    .container { width: 90%; max-width: 1200px; margin: 0 auto; padding: 40px 0; }
    .page-header { text-align: center; padding: 60px 20px; background-color: var(--bg-medium); }
    .page-header h1 { font-size: 48px; }
    .page-header p { font-size: 18px; color: var(--text-secondary); max-width: 600px; margin: 10px auto 30px; }
    .job-card { background-color: var(--bg-medium); border-radius: 12px; padding: 25px; margin-bottom: 20px; border: 1px solid var(--bg-light); transition: border-color 0.3s ease, transform 0.3s ease; }
    .job-card:hover { border-color: var(--accent); transform: translateY(-5px); }
    .job-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; flex-wrap: wrap; gap: 15px; }
    .job-card-title { font-size: 22px; }
    .job-card-company { font-size: 16px; color: var(--text-secondary); margin-top: 5px; }
    .job-tags { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
    .job-tag { background-color: var(--bg-light); color: var(--text-secondary); font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px; }
    .job-card-description { color: var(--text-secondary); line-height: 1.7; }
    .nav-button-primary { display: inline-block; background-color: var(--accent); color: var(--bg-dark); padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 700; }
</style>
@endpush

@section('content')
<header class="page-header">
    <h1>Manajemen Lowongan Kerja Anda</h1>
    <p>Lihat, edit, atau buat lowongan kerja baru untuk menemukan talenta terbaik bagi perusahaan Anda.</p>
    <a href="{{ route('jobs.create') }}" class="nav-button-primary">Buat Lowongan Baru</a>
</header>
<div class="container" id="job-list-container">
    {{-- Filter lowongan hanya untuk pengguna yang sedang login --}}
    @php
        $myJobs = $jobs->where('user_id', Auth::id());
    @endphp

    @forelse ($myJobs as $job)
        <div class="job-card">
            <div class="job-card-header">
                <div>
                    <h2 class="job-card-title">{{ $job->title }}</h2>
                    <p class="job-card-company">{{ $job->user->name }} • {{ $job->location }}</p>
                </div>
                {{-- Tombol ini bisa diarahkan ke halaman edit lowongan --}}
                <a href="{{ route('jobs.create', $job->id) }}" class="nav-button-primary" style="padding: 8px 20px;">Kelola</a>
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
        <p style="text-align: center; color: var(--text-secondary); padding: 40px 0;">Anda belum memposting lowongan kerja.</p>
    @endforelse
</div>
@endsection
