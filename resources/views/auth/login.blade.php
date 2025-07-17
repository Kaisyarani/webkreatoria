@extends('layouts.app')

@section('title', 'Login - Kreatoria')

@push('styles')
<style>
    /* CSS KHUSUS UNTUK HALAMAN LOGIN */
    main {
            margin-top: var(--navbar-height);
        }

    .form-section { display: flex; justify-content: center; align-items: center; padding: 80px 0; min-height: calc(100vh - var(--navbar-height) - 101px); }
    .form-container { background-color: var(--bg-medium); padding: 40px; border-radius: 12px; width: 100%; max-width: 450px; border: 1px solid var(--bg-light); }
    .form-container h1 { text-align: center; margin-bottom: 30px; font-size: 28px; }
    .form-group { margin-bottom: 20px; position: relative; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-secondary); }
    .form-group input { width: 100%; padding: 12px 16px; background-color: var(--bg-dark); border: 1px solid var(--bg-light); border-radius: 8px; color: var(--text-primary); font-size: 16px; }
    .form-group input:focus { outline: none; border-color: var(--accent); }
    .toggle-password { position: absolute; right: 16px; top: 42px; cursor: pointer; font-size: 18px; color: var(--text-secondary); }
    .form-options { display: flex; justify-content: flex-end; margin-bottom: 25px; }
    .form-options a { color: var(--accent); text-decoration: none; font-size: 14px; font-weight: 500; }
    .submit-btn { width: 100%; padding: 14px; border: none; border-radius: 8px; font-size: 16px; font-weight: 700; cursor: pointer; background-color: var(--accent); color: var(--bg-dark); }
    .switch-form { text-align: center; margin-top: 30px; font-size: 14px; color: var(--text-secondary); }
    .switch-form a { color: var(--accent); font-weight: 600; text-decoration: none; }
    .error-message { color: #ef4444; font-size: 13px; margin-top: 5px; }
    .footer { border-top: 1px solid var(--bg-light); text-align: center; padding: 40px 0; }
</style>
@endpush

@section('content')
<div class="form-section">
    <div class="form-container">
        <h1>Selamat Datang Kembali</h1>

        <form id="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email') <p class="error-message">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <i class="fa-solid fa-eye toggle-password" onclick="togglePassword()"></i>
                @error('password') <p class="error-message">{{ $message }}</p> @enderror
            </div>
            <div class="form-options">
                <a href="{{ route('password.request') }}">Lupa password?</a>
            </div>
            <button type="submit" class="submit-btn">Login</button>
        </form>
        <p class="switch-form">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.querySelector('.toggle-password');
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        toggleIcon.classList.toggle('fa-eye');
        toggleIcon.classList.toggle('fa-eye-slash');
    }
</script>
@endpush
