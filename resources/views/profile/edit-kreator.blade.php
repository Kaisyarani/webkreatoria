<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - Kreatoria</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
   @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap');
        :root { --bg-dark: #111827; --bg-medium: #1F2937; --bg-light: #374151; --text-primary: #F9FAFB; --text-secondary: #9CA3AF; --accent: #22D3EE; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg-dark); color: var(--text-primary); }
        .container { width: 90%; max-width: 1100px; margin: 0 auto; padding: 40px 0; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .page-header h1 { font-size: 28px; }
        .action-buttons { display: flex; gap: 15px; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 8px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; }
        .btn-primary { background-color: var(--accent); color: var(--bg-dark); }
        .btn-secondary { background-color: var(--bg-medium); color: var(--text-primary); }
        .profile-layout { display: flex; gap: 30px; }
        .sidebar { width: 250px; flex-shrink: 0; }
        .main-content { flex-grow: 1; }
        .photo-upload-wrapper { background-color: var(--bg-medium); padding: 20px; border-radius: 12px; text-align: center; margin-bottom: 20px; }
        .photo-preview { width: 120px; height: 120px; border-radius: 50%; border: 3px solid var(--bg-light); object-fit: cover; margin: 0 auto 15px auto; display: block; }
        .photo-upload-wrapper label, .banner-upload-wrapper label { color: var(--accent); cursor: pointer; font-weight: 600; display: block; padding: 8px; }

        /* ================== PERBAIKAN CSS BANNER DI SINI ================== */
        .banner-upload-wrapper {
            background-color: var(--bg-medium);
            padding: 15px;
            border-radius: 12px;
            text-align: center;
        }
        .banner-preview {
            width: 100%; /* Paksa lebar menjadi 100% dari parent */
            height: 100px; /* Beri tinggi yang tetap */
            object-fit: cover; /* Pastikan gambar menutupi area tanpa distorsi */
            border-radius: 8px;
            background-color: var(--bg-light);
            margin-bottom: 10px;
            display: block; /* Pastikan elemen ini adalah block */
        }
        /* ================================================================= */

        #photo, #banner { display: none; }
        .form-section { background-color: var(--bg-medium); border-radius: 12px; padding: 30px; margin-bottom: 20px; }
        .form-section h2 { font-size: 20px; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid var(--bg-light); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-secondary); }
        .form-group input, .form-group textarea { width: 100%; padding: 12px; background-color: var(--bg-dark); border: 1px solid var(--bg-light); border-radius: 8px; color: var(--text-primary); font-size: 15px; }
        .form-group textarea { min-height: 120px; }
        .grid-2-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        textarea#about {
        resize: none;
        }
        .dynamic-field-group { background-color: var(--bg-dark); padding: 20px; border-radius: 8px; margin-bottom: 15px; border: 1px solid var(--bg-light); position: relative; }
        .btn-remove-field { position: absolute; top: 15px; right: 15px; background: none; border: none; color: #ef4444; cursor: pointer; font-size: 20px; }
        #add-experience-btn, #add-education-btn { width: 100%; text-align: center; justify-content: center; background-color: var(--bg-light); color: var(--text-primary); }

        @media (max-width: 992px) { .profile-layout { flex-direction: column; } .sidebar { width: 100%; } }
        @media (max-width: 576px) { .grid-2-col { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
      <div class="container">
        <header class="page-header">
            <h1>Edit Profil Saya</h1>
            <div class="action-buttons">
                <a href="{{ route('profile.show', Auth::user()) }}" class="btn btn-secondary">Batal</a>
                <button form="edit-profile-form" type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Simpan Perubahan</button>
            </div>
        </header>

        @if (session('status'))
            <p style="color: var(--accent); margin-bottom: 20px;">{{ session('status') }}</p>
        @endif

        <form id="edit-profile-form" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="profile-layout">
                <aside class="sidebar">
                    <div class="photo-upload-wrapper">
                        <img src="{{ $profile->photo ? asset('storage/' . $profile->photo) : 'https://ui-avatars.com/api/?name='.$user->name.'&background=1F2937&color=F9FAFB&size=128' }}" alt="Foto Profil" id="photo-preview" class="photo-preview">
                        <label for="photo">Ubah Foto Profil</label>
                        <input type="file" id="photo" name="photo" accept="image/*">
                        @error('photo') <p class="error-message">{{ $message }}</p> @enderror
                    </div>
                    <div class="banner-upload-wrapper">
                        <img src="{{ $profile->banner ? asset('storage/' . $profile->banner) : 'https://placehold.co/600x200/1F2937/9CA3AF?text=Banner' }}" alt="Banner" id="banner-preview" class="banner-preview">
                        <label for="banner">Ubah Banner</label>
                        <input type="file" id="banner" name="banner" accept="image/*">
                        @error('banner') <p class="error-message">{{ $message }}</p> @enderror
                    </div>
                </aside>
                <main class="main-content">
                    <div class="form-section">
                        <h2>Informasi Dasar</h2>
                        <div class="form-group"><label for="name">Nama Lengkap</label><input type="text" id="name" name="name" placeholder="Nama lengkap Anda" value="{{ old('name', $user->name) }}" required> @error('name') <p class="error-message">{{ $message }} </p> @enderror </div>
                        <div class="form-group"><label for="title">Jabatan / Title</label><input type="text" id="title" name="title" placeholder="Contoh: UI/UX Designer" value="{{ old('title', $profile->title) }}"> @error('title') <p class="error-message">{{ $message }}</p> @enderror </div>
                        <div class="form-group"><label for="about">Tentang Saya/Ringkasan</label><textarea id="about" name="about" placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('about', $profile->about) }}</textarea> @error('about') <p class="error-message">{{ $message }}</p> @enderror </div>
                    </div>
                    <div class="form-section">
                        <h2>Keahlian & Tautan Sosial</h2>
                        <div class="form-group"><label for="skills">Keahlian (pisahkan dengan koma)</label><input type="text" id="skills" name="skills" placeholder="Contoh: Figma, HTML, CSS, JavaScript" value="{{ old('skills', implode(', ', $profile->skills ?? [])) }}"> @error('skills') <p class="error-message">{{ $message }}</p> @enderror </div>
                        <div class="grid-2-col">
                            <div class="form-group"><label for="social_linkedin">LinkedIn</label><input type="url" id="social_linkedin" name="social_linkedin" placeholder="https://linkedin.com/in/username" value="{{ old('social_linkedin', $profile->social_links['linkedin'] ?? '') }}"> @error('social_linkedin') <p class="error-message">{{ $message }}</p> @enderror </div>
                            <div class="form-group"><label for="social_dribbble">Dribbble / Behance</label><input type="url" id="social_dribbble" name="social_dribbble" placeholder="https://dribbble.com/username" value="{{ old('social_dribbble', $profile->social_links['dribbble'] ?? '') }}"> @error('social_dribbble') <p class="error-message">{{ $message }}</p> @enderror </div>
                        </div>
                    </div>
                    <div class="form-section">
                        <h2>Pengalaman Kerja</h2>
                        <div id="experience-fields-container"></div>
                        <button type="button" id="add-experience-btn" class="btn"><i class="fas fa-plus"></i> Tambah Pengalaman</button>
                    </div>

                    <div class="form-section">
                        <h2>Pendidikan</h2>
                        <div id="education-fields-container"></div>
                        <button type="button" id="add-education-btn" class="btn"><i class="fas fa-plus"></i> Tambah Pendidikan</button>
                    </div>
                </main>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function setupImagePreview(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                 // --- Logika untuk menambah & menghapus field ---
            function setupDynamicFields(containerId, buttonId, fieldHTMLGenerator) {
                const container = document.getElementById(containerId);
                const addButton = document.getElementById(buttonId);
                let count = 0;

                function addField() {
                    count++;
                    const fieldGroup = document.createElement('div');
                    fieldGroup.className = 'dynamic-field-group';
                    fieldGroup.innerHTML = fieldHTMLGenerator(count);
                    container.appendChild(fieldGroup);
                    fieldGroup.querySelector('.btn-remove-field').addEventListener('click', () => fieldGroup.remove());
                }
                addButton.addEventListener('click', addField);
                addField(); // Tambah satu field default
            }
                if (input && preview) {
                    input.addEventListener('change', function (event) {
                        const file = event.target.files[0];
                        if (file) {
                            preview.src = URL.createObjectURL(file);
                        }
                    });
                }
            }
            setupImagePreview('photo', 'photo-preview');
            setupImagePreview('banner', 'banner-preview');

          function setupDynamicFields(containerId, buttonId, templateGenerator, initialData) {
                const container = document.getElementById(containerId);
                const addButton = document.getElementById(buttonId);
                let count = 0;

                function addField(data = {}) {
                    const index = count++;
                    const fieldGroup = document.createElement('div');
                    fieldGroup.className = 'dynamic-field-group';
                    fieldGroup.innerHTML = templateGenerator(index, data);
                    container.appendChild(fieldGroup);
                    fieldGroup.querySelector('.btn-remove-field').addEventListener('click', () => fieldGroup.remove());
                }

                addButton.addEventListener('click', () => addField());

                initialData.forEach(item => addField(item));
                if (initialData.length === 0) {
                    addField();
                }
            }

            // Template untuk Pengalaman
            const expTemplate = (index, data) => `
                <button type="button" class="btn-remove-field" title="Hapus">&times;</button>
                <div class="form-group"><label>Jabatan</label><input type="text" name="experience[${index}][title]" value="${data.title || ''}" placeholder="Contoh: UI Designer"></div>
                <div class="form-group"><label>Perusahaan</label><input type="text" name="experience[${index}][company]" value="${data.company || ''}" placeholder="Contoh: PT Kreatoria Indonesia"></div>
                <div class="grid-2-col">
                    <div class="form-group"><label>Bulan Mulai</label><input type="month" name="experience[${index}][start]" value="${data.start || ''}"></div>
                    <div class="form-group"><label>Bulan Selesai</label><input type="month" name="experience[${index}][end]" value="${data.end || ''}"></div>
                </div>
            `;
            const existingExperience = @json($profile->experience ?? []);
            setupDynamicFields('experience-fields-container', 'add-experience-btn', expTemplate, existingExperience);

            // Template untuk Pendidikan
            const eduTemplate = (index, data) => `
                <button type="button" class="btn-remove-field" title="Hapus">&times;</button>
                <div class="form-group"><label>Nama Institusi</label><input type="text" name="education[${index}][school]" value="${data.school || ''}" placeholder="Contoh: Universitas Gadjah Mada"></div>
                <div class="form-group"><label>Gelar</label><input type="text" name="education[${index}][degree]" value="${data.degree || ''}" placeholder="Contoh: Sarjana Ilmu Komputer"></div>
                <div class="form-group"><label>Tahun Lulus</label><input type="number" name="education[${index}][year]" value="${data.year || ''}" placeholder="2025" min="1980" max="2040"></div>
            `;
            const existingEducation = @json($profile->education ?? []);
            setupDynamicFields('education-fields-container', 'add-education-btn', eduTemplate, existingEducation);
        });
    </script>
</body>
</html>
