@extends('layouts.guest')

@section('title', 'Register')

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

    .form-input:focus ~ .input-icon,
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

    /* Password strength indicator */
    .password-strength {
        margin-top: 6px;
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .strength-bar {
        height: 3px;
        flex: 1;
        border-radius: 2px;
        background: var(--border-color);
        transition: var(--transition);
    }

    .strength-bar.weak   { background: #E74C3C; }
    .strength-bar.medium { background: #F39C12; }
    .strength-bar.strong { background: #27AE60; }

    .strength-label {
        font-size: 0.72rem;
        color: var(--text-muted);
        min-width: 60px;
        text-align: right;
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

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')

<section class="auth-section">
    <h1 class="auth-title">Register</h1>
    <div class="auth-divider"></div>

    <div class="auth-card">

        {{-- Error Summary --}}
        @if ($errors->any())
            <div class="error-summary" id="error-summary">
                <i class="fas fa-exclamation-triangle"></i>
                <div>{{ $errors->first() }}</div>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" id="register-form" novalidate>
            @csrf

            {{-- Nama Lengkap --}}
            <div class="form-group">
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fas fa-user"></i></span>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-input {{ $errors->has('name') ? 'input-error' : '' }}"
                        placeholder="Nama Lengkap"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                    >
                </div>
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

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

            {{-- Nomor Handphone --}}
            <div class="form-group">
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fas fa-phone"></i></span>
                    <input
                        type="tel"
                        id="phone_number"
                        name="phone_number"
                        class="form-input {{ $errors->has('phone_number') ? 'input-error' : '' }}"
                        placeholder="Nomor Handphone"
                        value="{{ old('phone_number') }}"
                        required
                        autocomplete="tel"
                    >
                </div>
                @error('phone_number')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Kata Sandi --}}
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
                        autocomplete="new-password"
                    >
                    <button type="button" class="toggle-password" id="toggle-password-btn" aria-label="Tampilkan kata sandi">
                        <i class="fas fa-eye-slash" id="toggle-eye-icon"></i>
                    </button>
                </div>
                <div class="password-strength" id="strength-indicator" style="display:none;">
                    <div class="strength-bar" id="strength-bar-1"></div>
                    <div class="strength-bar" id="strength-bar-2"></div>
                    <div class="strength-bar" id="strength-bar-3"></div>
                    <span class="strength-label" id="strength-label"></span>
                </div>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Konfirmasi Kata Sandi --}}
            <div class="form-group">
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-input"
                        placeholder="Konfirmasi Kata Sandi"
                        required
                        autocomplete="new-password"
                    >
                    <button type="button" class="toggle-password" id="toggle-confirm-btn" aria-label="Tampilkan konfirmasi">
                        <i class="fas fa-eye-slash" id="toggle-confirm-icon"></i>
                    </button>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-auth-submit" id="register-submit-btn">
                Register
            </button>

        </form>

        <p class="auth-redirect">
            Sudah punya akun? <a href="{{ route('login') }}" id="go-login-link">Login</a>
        </p>

    </div>
</section>

@endsection

@push('scripts')
<script>
    // Toggle password visibility - main
    const toggleBtn = document.getElementById('toggle-password-btn');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('toggle-eye-icon');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            const isPass = passwordInput.type === 'password';
            passwordInput.type = isPass ? 'text' : 'password';
            eyeIcon.className = isPass ? 'fas fa-eye' : 'fas fa-eye-slash';
        });
    }

    // Toggle password visibility - confirm
    const toggleConfirm = document.getElementById('toggle-confirm-btn');
    const confirmInput = document.getElementById('password_confirmation');
    const confirmIcon = document.getElementById('toggle-confirm-icon');

    if (toggleConfirm) {
        toggleConfirm.addEventListener('click', () => {
            const isPass = confirmInput.type === 'password';
            confirmInput.type = isPass ? 'text' : 'password';
            confirmIcon.className = isPass ? 'fas fa-eye' : 'fas fa-eye-slash';
        });
    }

    // Password strength meter
    const strengthIndicator = document.getElementById('strength-indicator');
    const strengthBars = [
        document.getElementById('strength-bar-1'),
        document.getElementById('strength-bar-2'),
        document.getElementById('strength-bar-3'),
    ];
    const strengthLabel = document.getElementById('strength-label');

    function getStrength(password) {
        let score = 0;
        if (password.length >= 8) score++;
        if (/[A-Z]/.test(password) && /[a-z]/.test(password)) score++;
        if (/[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)) score++;
        return score;
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', () => {
            const val = passwordInput.value;
            if (!val) {
                strengthIndicator.style.display = 'none';
                return;
            }
            strengthIndicator.style.display = 'flex';
            const score = getStrength(val);
            const classes = ['weak', 'medium', 'strong'];
            const labels = ['Lemah', 'Sedang', 'Kuat'];

            strengthBars.forEach((bar, i) => {
                bar.className = 'strength-bar';
                if (i < score) bar.classList.add(classes[score - 1]);
            });
            strengthLabel.textContent = labels[score - 1] ?? '';
        });
    }

    // Loading state on submit
    const form = document.getElementById('register-form');
    const submitBtn = document.getElementById('register-submit-btn');

    if (form) {
        form.addEventListener('submit', () => {
            submitBtn.classList.add('loading');
            submitBtn.textContent = 'Mendaftar...';
        });
    }
</script>
@endpush
