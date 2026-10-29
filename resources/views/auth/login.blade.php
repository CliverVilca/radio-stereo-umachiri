@extends('layouts.login')

@section('content')
<style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif;
        overflow-x: hidden;
        background-color: #070c1d;
    }

    .login-body {
        background: url('/assets/images/radio-studio-modern.jpg') no-repeat center center fixed;
        background-size: cover;
        position: relative;
        min-height: 100vh;
    }

    .login-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at top right, rgba(29, 78, 216, 0.35) 0%, transparent 60%),
                    radial-gradient(circle at bottom left, rgba(250, 204, 21, 0.15) 0%, transparent 50%),
                    linear-gradient(135deg, rgba(7, 12, 29, 0.94) 0%, rgba(13, 23, 56, 0.92) 50%, rgba(8, 13, 31, 0.96) 100%);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 1;
    }

    .login-container {
        position: relative;
        z-index: 2;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .glass-card {
        background: rgba(15, 28, 63, 0.75);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 24px;
        padding: 3rem 2.5rem;
        box-shadow: 0 30px 70px -15px rgba(0, 0, 0, 0.7),
                    0 0 40px rgba(250, 204, 21, 0.08);
        width: 100%;
        max-width: 440px;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .glass-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ef4444 0%, #facc15 50%, #10b981 100%);
    }

    .glass-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 35px 80px -15px rgba(0, 0, 0, 0.8),
                    0 0 50px rgba(250, 204, 21, 0.15);
        border-color: rgba(250, 204, 21, 0.3);
    }

    .brand-logo-wrap {
        position: relative;
        width: 88px;
        height: 88px;
        margin: 0 auto 1.25rem;
    }

    .brand-logo {
        width: 88px;
        height: 88px;
        background: #0a1128;
        border-radius: 50%;
        padding: 4px;
        border: 2px solid #facc15;
        box-shadow: 0 0 25px rgba(250, 204, 21, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .brand-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .live-indicator {
        position: absolute;
        bottom: -2px;
        right: -2px;
        background: #ef4444;
        color: white;
        font-size: 0.62rem;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 20px;
        border: 2px solid #0a1128;
        letter-spacing: 0.05em;
        display: flex;
        align-items: center;
        gap: 3px;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.5);
    }

    .live-dot {
        width: 5px;
        height: 5px;
        background: white;
        border-radius: 50%;
        animation: pulseDot 1s infinite alternate;
    }

    @keyframes pulseDot {
        from { opacity: 0.4; transform: scale(0.8); }
        to { opacity: 1; transform: scale(1.1); }
    }

    .login-title {
        color: #ffffff;
        text-align: center;
        font-family: 'Montserrat', system-ui, sans-serif;
        font-weight: 900;
        font-size: 1.65rem;
        margin-bottom: 0.3rem;
        letter-spacing: -0.03em;
        text-transform: uppercase;
    }

    .login-subtitle {
        color: rgba(255, 255, 255, 0.65);
        text-align: center;
        margin-bottom: 2rem;
        font-size: 0.88rem;
        font-weight: 500;
    }

    .login-subtitle strong {
        color: #facc15;
        font-weight: 700;
    }

    .form-group-wrap {
        margin-bottom: 1.25rem;
    }

    .form-label-custom {
        display: block;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 0.4rem;
    }

    .input-wrap {
        position: relative;
    }

    .form-control-custom {
        width: 100%;
        background: rgba(7, 12, 29, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #ffffff;
        padding: 0.85rem 1rem 0.85rem 2.85rem;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.25s ease;
        box-sizing: border-box;
    }

    .form-control-custom:focus {
        background: rgba(7, 12, 29, 0.85);
        border-color: #facc15;
        box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.2);
        color: #ffffff;
        outline: none;
    }

    .form-control-custom::placeholder {
        color: rgba(255, 255, 255, 0.35);
    }

    .input-icon-custom {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.45);
        pointer-events: none;
        transition: color 0.25s ease;
        font-size: 0.95rem;
    }

    .form-control-custom:focus + .input-icon-custom {
        color: #facc15;
    }

    .form-check-custom {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-check-custom input {
        width: 17px;
        height: 17px;
        border-radius: 5px;
        accent-color: #facc15;
        cursor: pointer;
    }

    .form-check-custom label {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.85rem;
        cursor: pointer;
        user-select: none;
    }

    .btn-login-modern {
        background: linear-gradient(135deg, #facc15 0%, #eab308 100%);
        border: none;
        color: #070c1d;
        padding: 0.95rem;
        border-radius: 12px;
        font-family: 'Montserrat', system-ui, sans-serif;
        font-weight: 900;
        font-size: 0.95rem;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        width: 100%;
        margin-top: 1rem;
        transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 8px 25px rgba(250, 204, 21, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
    }

    .btn-login-modern:hover {
        background: linear-gradient(135deg, #fde047 0%, #facc15 100%);
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(250, 204, 21, 0.5);
        color: #000000;
    }

    .btn-login-modern:active {
        transform: translateY(0);
    }

    .back-home-pill {
        position: absolute;
        top: 24px;
        left: 24px;
        z-index: 10;
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.02em;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        transition: all 0.25s ease;
        background: rgba(15, 28, 63, 0.65);
        border: 1px solid rgba(255, 255, 255, 0.12);
        padding: 9px 18px;
        border-radius: 50px;
        backdrop-filter: blur(10px);
    }

    .back-home-pill:hover {
        color: #facc15;
        border-color: rgba(250, 204, 21, 0.4);
        background: rgba(15, 28, 63, 0.9);
        transform: translateX(-3px);
    }

    .footer-badge {
        text-align: center;
        margin-top: 1.75rem;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.45);
        font-size: 0.75rem;
        font-weight: 500;
    }
</style>

<div class="login-overlay"></div>

<a href="{{ url('/') }}" class="back-home-pill">
    <i class="fas fa-arrow-left text-warning"></i>
    <span>Volver a la Radio en Vivo</span>
</a>

<div class="login-container">
    <div class="glass-card">
        {{-- Logotipo con anillo dorado y badge en vivo --}}
        <div class="brand-logo-wrap">
            <div class="brand-logo">
                <img src="{{ asset('assets/images/logo-modern.jpg') }}" alt="Stereo Umachiri 98.5 FM" onerror="this.src='{{ asset('assets/images/logo.png') }}'">
            </div>
            <div class="live-indicator">
                <span class="live-dot"></span> 98.5
            </div>
        </div>
        
        <h1 class="login-title">PANEL DE CONTROL</h1>
        <p class="login-subtitle">Cabina Central · <strong>Stereo Umachiri</strong></p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group-wrap">
                <label for="email" class="form-label-custom">Correo de Acceso</label>
                <div class="input-wrap">
                    <input id="email" type="email" class="form-control-custom @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="admin@admin.com">
                    <i class="fas fa-envelope input-icon-custom"></i>
                </div>
                @error('email')
                    <span class="text-danger small mt-1 d-block fw-bold" role="alert">
                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group-wrap">
                <label for="password" class="form-label-custom">Contraseña de Seguridad</label>
                <div class="input-wrap">
                    <input id="password" type="password" class="form-control-custom @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                    <i class="fas fa-lock input-icon-custom"></i>
                </div>
                @error('password')
                    <span class="text-danger small mt-1 d-block fw-bold" role="alert">
                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check-custom">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Recordar sesión</label>
                </div>
                
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color: rgba(250,204,21,0.85); font-size: 0.8rem; text-decoration: none; font-weight: 600;">
                        ¿Olvidaste tu clave?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-login-modern">
                <span>INGRESAR A LA CABINA</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <div class="footer-badge">
            <i class="fas fa-shield-alt text-warning me-1"></i> Sistema Administrativo Seguro &copy; {{ date('Y') }}
        </div>
    </div>
</div>
@endsection
