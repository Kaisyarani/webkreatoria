@extends('layouts.app')

@section('title', 'Posting Karya Baru - Kreatoria')

@push('styles')
<style>
    main {
            margin-top: var(--navbar-height);
        }
    .container { width: 90%; max-width: 800px; margin: 40px auto; }
    .form-container { background-color: var(--bg-medium); padding: 40px; border-radius: 12px; border: 1px solid var(--bg-light); }
    .form-container h1 { text-align: center; margin-bottom: 30px; }
    .form-group { margin-bottom: 25px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 10px; color: var(--text-secondary); }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 16px; background-color: var(--bg-dark); border: 1px solid var(--bg-light); border-radius: 8px; color: var(--text-primary); font-size: 16px; font-family: 'Plus Jakarta Sans', sans-serif; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--accent); }
    .image-upload-wrapper { border: 2px dashed var(--bg-light); border-radius: 12px; padding: 40px; text-align: center; cursor: pointer; transition: border-color 0.3s; }
    .image-upload-wrapper:hover { border-color: var(--accent); }
    .image-upload-wrapper .icon { font-size: 40px; color: var(--text-secondary); margin-bottom: 15px; }
    .image-upload-wrapper p { color: var(--text-secondary); }
    #image-preview { max-width: 100%; max-height: 300px; border-radius: 8px; margin-top: 20px; display: none; }
    .submit-btn { width: 100%; padding: 14px; border: none; border-radius: 8px; font-size: 16px; font-weight: 700; cursor: pointer; background-color: var(--accent); color: var(--bg-dark); transition: all 0.3s ease; margin-top: 10px; }
    .submit-btn:hover { opacity: 0.9; }
    .error-message { color: #ef4444; font-size: 12px; margin-top: 5px; }
</style>
@endpush

@section('content')
<div class="container">
    <div class="form-container">
        <h1>Posting Karya Baru Anda</h1>

        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">Judul Karya</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Pilih Kategori</label>
                <select id="category" name="category" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="ui-ux" {{ old('category') == 'ui-ux' ? 'selected' : '' }}>UI/UX Design</option>
                    <option value="branding" {{ old('category') == 'branding' ? 'selected' : '' }}>Branding</option>
                    <option value="ilustrasi" {{ old('category') == 'ilustrasi' ? 'selected' : '' }}>Ilustrasi</option>
                    <option value="web-dev" {{ old('category') == 'web-dev' ? 'selected' : '' }}>Web Development</option>
                </select>
                @error('category')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

             <div class="form-group">
                <label for="description">Deskripsi Karya</label>
                <textarea id="description" name="description" rows="5" placeholder="Ceritakan tentang karya Anda, proses pembuatannya, atau cerita di baliknya...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Unggah Gambar Karya</label>
                <div class="image-upload-wrapper" onclick="document.getElementById('image-input').click()">
                    <input type="file" id="image-input" name="image" accept="image/*" style="display: none;" onchange="previewImage(event)" required>
                    <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                    <p>Seret & Jatuhkan atau Klik untuk Memilih File</p>
                    <p id="file-name" style="color: var(--accent); margin-top: 10px;"></p>
                </div>
                <img id="image-preview" src="#" alt="Image Preview"/>
                @error('image')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="submit-btn">Posting Karya</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        const imagePreview = document.getElementById('image-preview');
        const fileNameDisplay = document.getElementById('file-name');

        reader.onload = function(){
            imagePreview.src = reader.result;
            imagePreview.style.display = 'block';
        }

        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
            fileNameDisplay.textContent = event.target.files[0].name;
        }
    }
</script>
@endpush
