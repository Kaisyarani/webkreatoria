@extends('layouts.app')

@section('title', 'Pengaturan - Kreatoria')

@push('styles')
<style>
     main {
            margin-top: var(--navbar-height);
        }
    .container { width: 90%; max-width: 800px; margin: 0 auto; padding: 40px 0; }
    h1, h2, h3 { font-weight: 800; }
    .page-header { text-align: center; margin-bottom: 40px; margin-top: 20px; }
    .page-header h1 { font-size: 42px; margin-bottom: 5px; }
    .page-header p { color: var(--text-secondary); font-size: 18px; }
    .settings-card { background-color: var(--bg-medium); padding: 30px; border-radius: 12px; margin-bottom: 30px; }
    .settings-card h2 { font-size: 24px; margin-bottom: 25px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; color: var(--text-secondary); font-weight: 500; }
    .form-control { width: 100%; padding: 12px 15px; background-color: var(--bg-light); border: 1px solid var(--bg-light); border-radius: 8px; color: var(--text-primary); font-size: 16px; box-sizing: border-box; }
    .form-control:focus { outline: none; border-color: var(--accent); }
    .btn { padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 700; cursor: pointer; border: none; }
    .btn-primary { background-color: var(--accent); color: var(--bg-dark); }
    .danger-zone { border: 2px solid var(--danger, #ef4444); }
    .danger-zone h2 { color: var(--danger, #ef4444); }
    .danger-action { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
    .danger-action p { color: var(--text-secondary); max-width: 60%; }
    .btn-danger { background-color: var(--danger, #ef4444); color: var(--text-primary); }
    .btn-danger:hover { background-color: var(--danger-dark, #b91c1c); }
    .error-message { color: #ef4444; font-size: 13px; margin-top: 5px; }
    .success-message { color: #4ADE80; font-size: 14px; margin-bottom: 15px; }
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.8); z-index: 1000; display: none; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease; }
    .modal-overlay.show { display: flex; opacity: 1; }
    .modal-box { background-color: var(--bg-medium); padding: 40px; border-radius: 12px; width: 90%; max-width: 500px; text-align: center; }
    .modal-box h2 { font-size: 28px; margin-bottom: 15px; }
    .modal-box p { color: var(--text-secondary); margin-bottom: 30px; line-height: 1.6; }
    .modal-actions { display: flex; justify-content: center; gap: 20px; }
    .btn-secondary { background-color: var(--bg-light); color: var(--text-primary); }
</style>
@endpush

@section('content')
<div class="container">
    <header class="page-header">
        <h1>Pengaturan Akun</h1>
        <p>Kelola informasi akun dan keamanan Anda.</p>
    </header>

    <div class="settings-card">
        <h2>Ubah Password</h2>
        @if (session('status') === 'password-updated')
            <p class="success-message">Password berhasil diperbarui.</p>
        @endif
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="current_password">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" class="form-control" required>
                @error('current_password', 'updatePassword') <p class="error-message">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" class="form-control" required>
                @error('password', 'updatePassword') <p class="error-message">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Password</button>
        </form>
    </div>

    <div class="settings-card danger-zone">
        <h2>Zona Berbahaya</h2>
        <div class="danger-action">
            <div>
                <h4>Hapus Akun</h4>
                <p>Setelah akun Anda dihapus, semua data akan hilang selamanya. Harap berhati-hati.</p>
            </div>
            <button class="btn btn-danger" id="delete-account-btn">Hapus Akun Saya</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="delete-confirm-modal">
    <div class="modal-box">
        <h2>Apakah Anda Benar-Benar Yakin?</h2>
        <p>Untuk menghapus akun Anda, silakan masukkan password Anda untuk konfirmasi.</p>
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')
            <div class="form-group">
                <input type="password" name="password" placeholder="Password Anda" class="form-control" required>
                @error('password', 'userDeletion') <p class="error-message" style="text-align: left;">{{ $message }}</p> @enderror
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" id="cancel-delete-btn">Batal</button>
                <button type="submit" class="btn btn-danger">Ya, Hapus Akun Saya</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteBtn = document.getElementById('delete-account-btn');
    const cancelBtn = document.getElementById('cancel-delete-btn');
    const modal = document.getElementById('delete-confirm-modal');
    if (deleteBtn && modal) {
        deleteBtn.addEventListener('click', () => modal.classList.add('show'));
    }
    if (cancelBtn && modal) {
        cancelBtn.addEventListener('click', () => modal.classList.remove('show'));
    }
    // Jika ada error validasi saat hapus akun, tampilkan modal lagi
    @if($errors->userDeletion->isNotEmpty())
        if(modal) modal.classList.add('show');
    @endif
});
</script>
@endpush
