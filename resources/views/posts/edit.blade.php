@extends('layouts.app')

@section('title', 'Edit Karya: ' . $post->title)

@push('styles')
<style>
    body { padding-top: var(--navbar-height, 88px); }
    .container { width: 90%; max-width: 800px; margin: 40px auto; }
    .form-container { background-color: var(--bg-medium); padding: 40px; border-radius: 12px; border: 1px solid var(--bg-light); }
    .form-container h1 { text-align: center; margin-bottom: 30px; }
    .form-group { margin-bottom: 25px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 10px; color: var(--text-secondary); }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 16px; background-color: var(--bg-dark); border: 1px solid var(--bg-light); border-radius: 8px; color: var(--text-primary); font-size: 16px; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--accent); }
    .image-upload-wrapper { border: 2px dashed var(--bg-light); border-radius: 12px; padding: 20px; text-align: center; cursor: pointer; }
    #image-preview { max-width: 100%; border-radius: 8px; margin-top: 20px; display: block; }
    .submit-btn { width: 100%; padding: 14px; border: none; border-radius: 8px; font-size: 16px; font-weight: 700; cursor: pointer; background-color: var(--accent); color: var(--bg-dark); margin-top: 10px; }
    .error-message { color: #ef4444; font-size: 12px; margin-top: 5px; }
</style>
@endpush

@section('content')
<div class="container">
    <div class="form-container">
        <h1>Edit Karya Anda</h1>

        <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH') {{-- Method untuk update --}}

            <div class="form-group">
                <label for="title">Judul Karya</label>
                <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                @error('title') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="category">Pilih Kategori</label>
                <select id="category" name="category" required>
                    <option value="ui-ux" {{ old('category', $post->category) == 'ui-ux' ? 'selected' : '' }}>UI/UX Design</option>
                    <option value="branding" {{ old('category', $post->category) == 'branding' ? 'selected' : '' }}>Branding</option>
                    <option value="ilustrasi" {{ old('category', $post->category) == 'ilustrasi' ? 'selected' : '' }}>Ilustrasi</option>
                    <option value="web-dev" {{ old('category', $post->category) == 'web-dev' ? 'selected' : '' }}>Web Development</option>
                </select>
                @error('category') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" rows="4">{{ old('description', $post->description) }}</textarea>
                @error('description') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Ubah Gambar Karya (Opsional)</label>
                <div class="image-upload-wrapper" onclick="document.getElementById('image-input').click()">
                    <input type="file" id="image-input" name="image" accept="image/*" style="display: none;" onchange="previewImage(event)">
                    <p>Klik untuk memilih gambar baru</p>
                </div>
                <img id="image-preview" src="{{ asset('storage/' . $post->image) }}" alt="Image Preview"/>
                @error('image') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="submit-btn">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        const imagePreview = document.getElementById('image-preview');
        reader.onload = function(){
            imagePreview.src = reader.result;
        }
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endpush
