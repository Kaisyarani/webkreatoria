<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Lowongan - Kreatoria</title>
    <style>
        /* ... (CSS lain tetap sama) ... */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap');
        :root { --bg-dark: #111827; --bg-medium: #1F2937; --bg-light: #374151; --text-primary: #F9FAFB; --text-secondary: #9CA3AF; --accent: #22D3EE; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg-dark); color: var(--text-primary); }
        .container { width: 90%; max-width: 800px; margin: 40px auto; }
        .page-header { text-align: center; padding: 60px 20px; }
        .page-header h1 { font-size: 48px; }
        .page-header p { font-size: 18px; color: var(--text-secondary); max-width: 600px; margin: 10px auto 0; }
        .form-container { background-color: var(--bg-medium); padding: 40px; border-radius: 12px; }
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 10px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 16px; background-color: var(--bg-dark); border: 1px solid var(--bg-light); border-radius: 8px; color: var(--text-primary); font-size: 16px; }
        .form-group textarea { min-height: 150px; }
        .form-group small { color: var(--text-secondary); margin-top: 8px; display: block; }
        .submit-btn { width: 100%; padding: 14px; border: none; border-radius: 8px; font-size: 16px; font-weight: 700; cursor: pointer; background-color: var(--accent); color: var(--bg-dark); margin-top: 10px; }
        .error-message { color: #ef4444; font-size: 12px; margin-top: 5px; }

        .form-group input[type="date"] {
            position: relative;
            color: var(--text-secondary); /* Warna placeholder (dd/mm/yyyy) */
        }

        /* Saat tanggal sudah dipilih, ganti warna teksnya */
        .form-group input[type="date"]:valid,
        .form-group input[type="date"]:focus {
            color: var(--text-primary);
        }

        /* Trik untuk membuat seluruh area input bisa diklik */
        .form-group input[type="date"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: 100%;
        }

        textarea#description {
        resize: none;
        }
    </style>
</head>
<body>
    <main>
        <header class="page-header">
            <h1>Buat Lowongan Pekerjaan Baru</h1>
            <p>Isi detail di bawah ini untuk menjangkau talenta terbaik di komunitas Kreatoria.</p>
        </header>

        <div class="container">
            <div class="form-container">
                <form id="post-job-form" method="POST" action="{{ route('jobs.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="title">Judul Pekerjaan</label>
                        <input type="text" id="title" name="title" placeholder="Contoh: Senior UI/UX Designer" value="{{ old('title') }}" required>
                        @error('title') <p class="error-message">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="location">Lokasi</label>
                        <input type="text" id="location" name="location" placeholder="Contoh: Jakarta, Remote, Hybrid" value="{{ old('location') }}" required>
                        @error('location') <p class="error-message">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="deadline">Tenggat Lowongan</label>
                        <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}" required>
                        @error('deadline') <p class="error-message">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="type">Tipe Pekerjaan</label>
                        <select id="type" name="type" required>
                            <option value="Full-time" {{ old('type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="Part-time" {{ old('type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                            <option value="Contract" {{ old('type') == 'Contract' ? 'selected' : '' }}>Kontrak</option>
                            <option value="Internship" {{ old('type') == 'Internship' ? 'selected' : '' }}>Magang</option>
                            <option value="Freelance" {{ old('type') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                        </select>
                        @error('type') <p class="error-message">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label for="tags">Tags / Kategori</label>
                        <input type="text" id="tags" name="tags" placeholder="Pisahkan dengan koma" value="{{ old('tags') }}" required>
                        <small>Contoh: UI/UX, Developer, React, Marketing</small>
                        @error('tags') <p class="error-message">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi Pekerjaan</label>
                        <textarea id="description" name="description" placeholder="Jelaskan tentang peran, tanggung jawab, dan kualifikasi yang dibutuhkan..." required>{{ old('description') }}</textarea>
                        @error('description') <p class="error-message">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="submit-btn">Posting Lowongan</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
