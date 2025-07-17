<!DOCTYPE html>
    <html lang="id">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>Lupa Password - Kreatoria</title>
      <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap');
        :root { --bg-dark: #111827; --bg-medium: #1F2937; --bg-light: #374151; --text-primary: #F9FAFB; --text-secondary: #9CA3AF; --accent: #22D3EE; }
        body { background: #111827; color: #fff; font-family: 'Plus Jakarta Sans', sans-serif; display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .form-wrapper { text-align: center; width: 90%; max-width: 450px; }
        .form-wrapper h2 { margin-bottom: 10px; font-size: 28px; }
        .form-wrapper p { color: var(--text-secondary); margin-bottom: 30px; }
        form { background: #1F2937; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.3); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; text-align: left; margin-bottom: 8px; font-weight: 600; }
        input { width: 100%; padding: 12px; border: 1px solid var(--bg-light); border-radius: 8px; background: #374151; color: #fff; font-size: 16px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #22D3EE; border: none; border-radius: 8px; font-weight: bold; color: #111827; cursor: pointer; font-size: 16px; }
        .message { margin-top: 20px; font-size: 14px; text-align: center; }
        .message.error { color: #F87171; }
        .message.success { color: #4ADE80; }
        .back-to-login { margin-top: 20px; color: var(--text-secondary); }
        .back-to-login a { color: var(--accent); text-decoration: none; }
      </style>
    </head>
    <body>
      <div class="form-wrapper">
        <h2>Lupa Password Anda?</h2>
        <p>Tidak masalah. Cukup beritahu kami alamat email Anda dan kami akan mengirimkan link untuk mengatur ulang password Anda.</p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="message success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus />
                @error('email')
                    <div class="message error">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit">Kirim Link Reset Password</button>
        </form>
        <p class="back-to-login"><a href="{{ route('login') }}">Kembali ke Login</a></p>
      </div>
    </body>
    </html>
