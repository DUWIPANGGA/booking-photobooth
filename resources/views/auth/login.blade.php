@extends('layouts.guest')

@section('title', 'Login')

@push('styles')
<style>
    .auth-section {
        min-height: calc(100vh - 130px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 50px 24px;
        background-color: var(--bg-light);
    }

    .auth-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 6px;
        text-align: center;
    }

    .auth-divider {
        width: 70px;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--primary-soft), transparent);
        margin: 0 auto 34px;
    }

    .auth-card {
        background: var(--bg-card);
        border-radius: var(--radius-md);
        padding: 44px 48px;
        width: 100%;
        max-width: 540px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
    }

    /* ===== FORM FIELD ===== */
    .form-group {
        margin-bottom: 14px;
        position: relative;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 18px;
        color: var(--primary-soft);
        font-size: 1rem;
        pointer-events: none;
        transition: var(--transition);
        z-index: 1;
    }

    .form-input {
        width: 100%;
        padding: 16px 18px 16px 50px;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-sm);
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        color: var(--text-dark);
        background: var(--bg-card);
        transition: var(--transition);
        outline: none;
        appearance: none;
    }

    .form-input::placeholder {
        color: var(--primary-soft);
        opacity: 0.7;
    }

    .form-input:focus {
        border-color: var(--primary-soft);
        box-shadow: 0 0 0 3px rgba(123,45,62,0.08);
    }

    .form-input:focus + .input-icon,
    .input-wrapper:focus-within .input-icon {
        color: var(--primary);
    }

    /* Password toggle */
    .toggle-password {
        position: absolute;
        right: 16px;
        background: none;
        border: none;
        color: var(--primary-soft);
        cursor: pointer;
        padding: 4px;
        font-size: 1rem;
        transition: var(--transition);
        z-index: 1;
    }

    .toggle-password:hover { color: var(--primary); }

    /* ===== ERRORS ===== */
    .form-error {
        color: #C0392B;
        font-size: 0.78rem;
        margin-top: 5px;
        padding-left: 4px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .form-error::before { content: '⚠'; font-size: 0.75rem; }

    .input-error { border-color: #C0392B !important; }
    .input-error:focus { box-shadow: 0 0 0 3px rgba(192,57,43,0.1) !important; }

    /* Error summary box */
    .error-summary {
        background: #FDF2F2;
        border: 1px solid #F5C6CB;
        border-radius: var(--radius-sm);
        padding: 12px 16px;
        margin-bottom: 18px;
        font-size: 0.83rem;
        color: #721C24;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .error-summary i { color: #C0392B; margin-top: 2px; flex-shrink: 0; }

    /* ===== FORGOT PASSWORD ===== */
    .forgot-link-row {
        text-align: right;
        margin-top: -4px;
        margin-bottom: 8px;
    }

    .forgot-link {
        color: var(--primary-soft);
        font-size: 0.8rem;
        text-decoration: none;
        transition: var(--transition);
    }

    .forgot-link:hover { color: var(--primary); text-decoration: underline; }

    /* ===== SUBMIT BUTTON ===== */
    .btn-auth-submit {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: var(--white);
        border: none;
        border-radius: var(--radius-sm);
        font-family: 'Playfair Display', serif;
        font-size: 1.05rem;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
        margin-top: 8px;
        box-shadow: 0 4px 16px rgba(123,45,62,0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-auth-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(123,45,62,0.35);
    }

    .btn-auth-submit:active { transform: translateY(0); }

    /* ===== REDIRECT LINK ===== */
    .auth-redirect {
        text-align: center;
        margin-top: 22px;
        font-size: 0.875rem;
        color: var(--text-muted);
    }

    .auth-redirect a {
        color: var(--primary-dark);
        font-weight: 700;
        text-decoration: none;
        transition: var(--transition);
    }

    .auth-redirect a:hover {
        color: var(--primary);
        text-decoration: underline;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 576px) {
        .auth-card { padding: 30px 24px; }
        .auth-title { font-size: 1.7rem; }
    }

    /* Loading state */
    .btn-auth-submit.loading {
        opacity: 0.85;
        pointer-events: none;
    }

    .btn-auth-submit.loading::after {
        content: '';
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255,255,255,0.4);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin-left: 8px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')

<div class="auth-header" style="background: #80404D; padding: 15px 40px; display: flex; align-items: center; gap: 15px;">
    <div style="width: 44px; height: 44px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
        <img src="https://ui-avatars.com/api/?name=V&background=fff&color=7B2D3E" alt="Logo" style="width: 100%;">
    </div>
    <span style="font-family: 'Great Vibes', cursive; color: white; font-size: 1.8rem;">Vibes Studio</span>
</div>

<section class="auth-section">
    <h1 class="auth-title" style="margin-top: 40px;">Login</h1>
    <div class="auth-divider" style="background: #D2B48C; height: 1px; width: 150px; opacity: 1;"></div>

    <div class="auth-card" style="margin-top: 0;">

        {{-- Error Summary --}}
        @if ($errors->any())
            <div class="error-summary" id="error-summary">
                <i class="fas fa-exclamation-triangle"></i>
                <div>{{ $errors->first() }}</div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="login-form" novalidate>
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input {{ $errors->has('email') ? 'input-error' : '' }}"
                        placeholder="Email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                    >
                </div>
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input {{ $errors->has('password') ? 'input-error' : '' }}"
                        placeholder="Kata Sandi"
                        required
                        autocomplete="current-password"
                    >
                    <button type="button" class="toggle-password" id="toggle-password-btn" aria-label="Tampilkan kata sandi">
                        <i class="fas fa-eye-slash" id="toggle-eye-icon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Lupa Password --}}
            <div class="forgot-link-row">
                <a href="#" class="forgot-link" id="forgot-password-link">Lupa kata sandi?</a>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-auth-submit" id="login-submit-btn">
                Login
            </button>

        </form>

        <p class="auth-redirect">
            Belum punya akun? <a href="{{ route('register') }}" id="go-register-link">Buat Akun</a>
        </p>

    </div>
</section>

@endsection

@push('scripts')
<script>
    // Toggle password visibility
    const toggleBtn = document.getElementById('toggle-password-btn');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('toggle-eye-icon');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.className = isPassword ? 'fas fa-eye' : 'fas fa-eye-slash';
        });
    }

    // Loading state on submit
    const form = document.getElementById('login-form');
    const submitBtn = document.getElementById('login-submit-btn');

    if (form) {
        form.addEventListener('submit', () => {
            submitBtn.classList.add('loading');
            submitBtn.textContent = 'Masuk...';
        });
    }
</script>
@endpush
