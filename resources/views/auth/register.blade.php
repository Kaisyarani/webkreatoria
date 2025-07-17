@extends('layouts.app')

@section('title', 'Sign Up - Kreatoria')

@push('styles')
<style>
    /* CSS KHUSUS UNTUK HALAMAN REGISTER */
    main {
            margin-top: var(--navbar-height);
        }

    .form-section { display: flex; justify-content: center; align-items: center; padding: 80px 0; min-height: calc(100vh - var(--navbar-height) - 101px); }
    .form-container { background-color: var(--bg-medium); padding: 40px; border-radius: 12px; width: 100%; max-width: 500px; border: 1px solid var(--bg-light); }
    .form-container h1 { text-align: center; margin-bottom: 15px; }
    .form-container p.subtitle { text-align: center; color: var(--text-secondary); margin-bottom: 30px; font-size: 16px; }
    .account-type-selector { display: flex; background-color: var(--bg-dark); border-radius: 8px; padding: 5px; margin-bottom: 30px; }
    .account-type-btn { flex: 1; text-align: center; padding: 10px; border-radius: 6px; border: none; background-color: transparent; color: var(--text-secondary); font-size: 14px; font-weight: 600; cursor: pointer; }
    .account-type-btn.active { background-color: var(--accent); color: var(--bg-dark); }
    .form-group { margin-bottom: 20px; position: relative; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-secondary); }
    .form-group input { width: 100%; padding: 12px 16px; background-color: var(--bg-dark); border: 1px solid var(--bg-light); border-radius: 8px; color: var(--text-primary); font-size: 16px; }
    #company-fields { display: none; }
    .submit-btn { width: 100%; padding: 14px; border: none; border-radius: 8px; font-size: 16px; font-weight: 700; cursor: pointer; background-color: var(--accent); color: var(--bg-dark); margin-top: 10px; }
    .switch-form { text-align: center; margin-top: 30px; font-size: 14px; color: var(--text-secondary); }
    .switch-form a { color: var(--accent); font-weight: 600; text-decoration: none; }
    .error-message { color: #ef4444; font-size: 13px; margin-top: 5px; }
    .footer { border-top: 1px solid var(--bg-light); text-align: center; padding: 40px 0; }
</style>
@endpush

@section('content')
<div class="form-section">
    <div class="form-container">
        <h1>Bergabung dengan Kreatoria</h1>
        <p class="subtitle">Mulai perjalanan kreatifmu hari ini.</p>
        <div class="account-type-selector">
            <button id="btn-kreator" class="account-type-btn active">Saya Kreator</button>
            <button id="btn-perusahaan" class="account-type-btn">Saya Perusahaan</button>
        </div>
        <form id="signup-form" method="POST" action="{{ route('register') }}">
            @csrf
            <div style="display: none;">
                <input type="radio" name="accountType" value="user" id="radio-user" checked>
                <input type="radio" name="accountType" value="company" id="radio-company">
            </div>
            <div id="kreator-fields">
                <div class="form-group"><label for="username">Nama Lengkap</label><input type="text" id="username" name="username" value="{{ old('username') }}" required>@error('username')<p class="error-message">{{ $message }}</p>@enderror</div>
            </div>
            <div id="company-fields">
                <div class="form-group"><label for="companyName">Nama Perusahaan</label><input type="text" id="companyName" name="companyName" value="{{ old('companyName') }}">@error('companyName')<p class="error-message">{{ $message }}</p>@enderror</div>
            </div>
            <div class="form-group"><label for="email">Email</label><input type="email" id="email" name="email" value="{{ old('email') }}" required>@error('email')<p class="error-message">{{ $message }}</p>@enderror</div>
            <div class="form-group"><label for="password">Password</label><input type="password" id="password" name="password" required>@error('password')<p class="error-message">{{ $message }}</p>@enderror</div>
            <div class="form-group"><label for="password_confirmation">Konfirmasi Password</label><input type="password" id="password_confirmation" name="password_confirmation" required></div>
            <button type="submit" class="submit-btn">Buat Akun</button>
        </form>
        <p class="switch-form">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnKreator = document.getElementById('btn-kreator');
        const btnPerusahaan = document.getElementById('btn-perusahaan');
        const kreatorFields = document.getElementById('kreator-fields');
        const companyFields = document.getElementById('company-fields');
        const companyNameInput = document.getElementById('companyName');
        const kreatorNameInput = document.getElementById('username');
        const radioUser = document.getElementById('radio-user');
        const radioCompany = document.getElementById('radio-company');

        btnKreator.addEventListener('click', () => {
            btnKreator.classList.add('active');
            btnPerusahaan.classList.remove('active');
            kreatorFields.style.display = 'block';
            companyFields.style.display = 'none';
            kreatorNameInput.required = true;
            companyNameInput.required = false;
            radioUser.checked = true;
        });

        btnPerusahaan.addEventListener('click', () => {
            btnPerusahaan.classList.add('active');
            btnKreator.classList.remove('active');
            kreatorFields.style.display = 'none';
            companyFields.style.display = 'block';
            kreatorNameInput.required = false;
            companyNameInput.required = true;
            radioCompany.checked = true;
        });
    });
</script>
@endpush
