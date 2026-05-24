@extends('layouts.app')

@push('styles')
<style>
:root {
    --auth-green: #17382b;
    --auth-green-light: #2d6a4f;
    --auth-gold: #c8a165;
    --auth-gold-light: #e2c08d;
    --auth-ink: #1f2d26;
    --auth-muted: #6f7d73;
    --auth-line: rgba(26, 60, 46, 0.12);
    --auth-soft: #f8f5f0;
    --auth-shadow: 0 22px 54px rgba(26, 60, 46, 0.13);
}

.auth-page {
    min-height: 100vh;
    overflow: hidden;
    background:
        radial-gradient(circle at 8% 12%, rgba(45,106,79,0.1), transparent 28%),
        radial-gradient(circle at 92% 18%, rgba(200,161,101,0.12), transparent 24%),
        linear-gradient(180deg, #fff 0%, var(--auth-soft) 100%);
}

.auth-hero {
    position: relative;
    min-height: 330px;
    display: flex;
    align-items: center;
    margin-top: 50px;
    color: #fff;
    background:
        linear-gradient(105deg, rgba(12,24,18,0.94) 0%, rgba(23,56,43,0.82) 58%, rgba(45,106,79,0.58) 100%),
        url('https://images.unsplash.com/photo-1611078489935-0cb964de46d6?q=80&w=1920&auto=format&fit=crop');
    background-size: cover;
    background-position: center;
}

.auth-hero::after {
    content: '';
    position: absolute;
    inset: auto 0 0;
    height: 88px;
    background: linear-gradient(180deg, transparent, rgba(248,245,240,0.98));
}

.auth-hero-content {
    position: relative;
    z-index: 2;
    padding: 88px 0 112px;
}

.auth-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: 1px solid rgba(226,192,141,0.42);
    border-radius: 50px;
    background: rgba(200,161,101,0.14);
    color: var(--auth-gold-light);
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 2.2px;
    text-transform: uppercase;
    margin-bottom: 18px;
}

.auth-hero h1,
.auth-title {
    font-family: 'Playfair Display', serif;
    font-weight: 800;
    letter-spacing: 0;
}

.auth-hero p {
    max-width: 640px;
    color: rgba(255,255,255,0.84);
    line-height: 1.8;
}

.auth-shell {
    position: relative;
    z-index: 5;
    margin-top: -64px;
    padding-bottom: 82px;
}

.auth-layout {
    align-items: stretch;
}

.auth-story,
.auth-card {
    height: 100%;
    overflow: hidden;
    border: 1px solid var(--auth-line);
    border-radius: 8px;
    box-shadow: var(--auth-shadow);
}

.auth-story {
    position: relative;
    min-height: 560px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: clamp(28px, 4vw, 44px);
    color: #fff;
    background:
        linear-gradient(180deg, rgba(23,56,43,0.08) 0%, rgba(23,56,43,0.92) 100%),
        url('https://images.unsplash.com/photo-1585435557343-3b092031a831?q=80&w=1100&auto=format&fit=crop');
    background-size: cover;
    background-position: center;
}

.auth-story::before {
    content: '';
    position: absolute;
    inset: 22px;
    border: 1px solid rgba(226,192,141,0.32);
    border-radius: 8px;
    pointer-events: none;
}

.auth-story-content {
    position: relative;
    z-index: 2;
}

.auth-story h2 {
    max-width: 460px;
}

.auth-story p {
    max-width: 520px;
    color: rgba(255,255,255,0.8);
    line-height: 1.8;
}

.auth-trust-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
    margin-top: 24px;
}

.auth-trust-chip {
    min-height: 78px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 8px;
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 8px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(12px);
    padding: 14px;
    transition: transform 0.24s ease, background 0.24s ease, border-color 0.24s ease;
}

.auth-trust-chip:hover {
    transform: translateY(-4px);
    border-color: rgba(226,192,141,0.52);
    background: rgba(200,161,101,0.18);
}

.auth-trust-chip i {
    color: var(--auth-gold-light);
}

.auth-trust-chip span {
    font-size: 0.78rem;
    font-weight: 900;
}

.auth-card {
    position: relative;
    background: linear-gradient(180deg, #fff 0%, #fbf8f1 100%);
}

.auth-card::before {
    content: '';
    position: absolute;
    inset: 0 0 auto;
    height: 5px;
    background: linear-gradient(90deg, var(--auth-gold), var(--auth-green-light));
}

.auth-card-inner {
    padding: clamp(26px, 4vw, 44px);
}

.auth-title {
    position: relative;
    display: inline-block;
    width: fit-content;
    color: #123524;
    background: linear-gradient(135deg, #0f3d2e 0%, #2f7d4f 48%, #c7962e 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    padding-bottom: 12px;
    margin-bottom: 16px;
    text-shadow: 0 12px 28px rgba(27, 67, 50, 0.12);
}

.auth-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 82px;
    height: 4px;
    border-radius: 999px;
    background: linear-gradient(90deg, #2f7d4f, #d4a853);
    box-shadow: 0 8px 18px rgba(212, 168, 83, 0.28);
}

.auth-copy {
    color: var(--auth-muted);
    line-height: 1.75;
}

.auth-alert {
    border: 0;
    border-radius: 8px;
    box-shadow: 0 10px 24px rgba(26,60,46,0.08);
}

.auth-field label {
    color: var(--auth-green);
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.auth-control {
    min-height: 54px;
    border: 1px solid rgba(26,60,46,0.12) !important;
    border-radius: 8px !important;
    background: #fff !important;
    color: var(--auth-ink) !important;
    padding: 12px 16px !important;
    box-shadow: none !important;
    transition: border-color 0.22s ease, box-shadow 0.22s ease, transform 0.22s ease;
}

.auth-control:focus {
    border-color: rgba(200,161,101,0.72) !important;
    box-shadow: 0 0 0 4px rgba(200,161,101,0.14) !important;
    transform: translateY(-1px);
}

.auth-password-input {
    border-radius: 8px 0 0 8px !important;
}

.auth-password-toggle {
    min-width: 54px;
    border: 1px solid rgba(26,60,46,0.12) !important;
    border-left: 0 !important;
    border-radius: 0 8px 8px 0 !important;
    color: var(--auth-green) !important;
    background: #fff !important;
}

.auth-remember {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin: 22px 0 24px;
}

.auth-remember .form-check-input {
    border-color: rgba(26,60,46,0.25);
    box-shadow: none;
}

.auth-remember .form-check-input:checked {
    background-color: var(--auth-green);
    border-color: var(--auth-green);
}

.auth-submit {
    min-height: 56px;
    border: 0;
    border-radius: 8px;
    color: #fff;
    background: linear-gradient(135deg, var(--auth-green), var(--auth-green-light));
    font-weight: 900;
    box-shadow: 0 16px 34px rgba(26,60,46,0.22);
    transition: transform 0.24s ease, box-shadow 0.24s ease, filter 0.24s ease;
}

.auth-submit:hover,
.auth-submit:focus {
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 24px 46px rgba(26,60,46,0.28);
    filter: brightness(1.04);
}

.auth-login-note {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    border: 1px solid rgba(200,161,101,0.26);
    border-radius: 8px;
    color: var(--auth-muted);
    background: rgba(200,161,101,0.1);
    padding: 13px 14px;
    font-size: 0.82rem;
    line-height: 1.55;
}

.auth-login-note i {
    color: var(--auth-gold);
    margin-top: 3px;
}

.auth-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--auth-muted);
    font-size: 0.78rem;
    font-weight: 900;
    letter-spacing: 1.1px;
    text-transform: uppercase;
    margin: 24px 0;
}

.auth-divider::before,
.auth-divider::after {
    content: '';
    height: 1px;
    flex: 1;
    background: rgba(26,60,46,0.1);
}

.auth-register {
    text-align: center;
    color: var(--auth-muted);
}

.auth-register a {
    color: var(--auth-green);
    font-weight: 900;
    text-decoration: none;
}

.auth-register a:hover {
    color: var(--auth-gold);
}

.auth-mini-row {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 10px;
    margin-top: 22px;
}

.auth-mini-chip {
    min-height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    border: 1px solid rgba(200,161,101,0.24);
    border-radius: 8px;
    color: var(--auth-green);
    background: rgba(200,161,101,0.12);
    font-size: 0.7rem;
    font-weight: 900;
}

.auth-fade {
    animation: authFade 0.55s ease both;
}

@keyframes authFade {
    from {
        opacity: 0;
        transform: translateY(16px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 991.98px) {
    .auth-hero {
        margin-top: 0;
        min-height: auto;
    }

    .auth-hero-content {
        padding: 108px 0 94px;
    }

    .auth-shell {
        margin-top: 0;
        padding-top: 48px;
    }

    .auth-story {
        min-height: 420px;
    }
}

@media (max-width: 575.98px) {
    .auth-hero h1 {
        font-size: 2.5rem;
    }

    .auth-trust-grid,
    .auth-mini-row {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<main class="auth-page">
    <section class="auth-hero">
        <div class="container">
            <div class="auth-hero-content auth-fade">
                <span class="auth-badge">
                    <i class="fas fa-lock"></i>
                    {{ __('Secure Login') }}
                </span>
                <h1 class="display-4 mb-3">{{ __('Welcome Back') }}</h1>
                <p class="lead mb-0">
                    {{ __('Sign in to manage orders, wishlist items, and your herbal wellness account.') }}
                </p>
            </div>
        </div>
    </section>

    <section class="auth-shell">
        <div class="container">
            <div class="row auth-layout g-4 g-lg-5 justify-content-center">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="auth-story auth-fade">
                        <div class="auth-story-content">
                            <span class="auth-badge">
                                <i class="fas fa-leaf"></i>
                                {{ __('Dawakhana Care') }}
                            </span>
                            <h2 class="playfair display-6 fw-bold mb-3 text-white">{{ __('Your wellness cabinet, one login away') }}</h2>
                            <p class="mb-0">{{ __('Access your order history, save favorite products, and keep your account details ready for faster checkout.') }}</p>

                            <div class="auth-trust-grid">
                                <div class="auth-trust-chip">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>{{ __('Protected') }}</span>
                                </div>
                                <div class="auth-trust-chip">
                                    <i class="fas fa-box"></i>
                                    <span>{{ __('Orders') }}</span>
                                </div>
                                <div class="auth-trust-chip">
                                    <i class="fas fa-heart"></i>
                                    <span>{{ __('Wishlist') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 col-lg-6 col-xl-5">
                    <div class="auth-card auth-fade">
                        <div class="auth-card-inner">
                            <h2 class="auth-title h1">{{ __('Login to Dawakhana') }}</h2>
                            <p class="auth-copy mb-4">{{ __('Enter your email and password to manage orders, wishlist items, and your herbal wellness account.') }}</p>

                            @if(session('error'))
                                <div class="alert alert-danger auth-alert small mb-4">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger auth-alert small mb-4">
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('login') }}" method="POST" id="login-form">
                                @csrf
                                <div class="mb-3 auth-field">
                                    <label class="form-label">{{ __('Email Address') }}</label>
                                    <input type="email"
                                        name="email"
                                        class="form-control auth-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}"
                                        required
                                        autocomplete="email"
                                        placeholder="you@example.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 auth-field">
                                    <label class="form-label">{{ __('Password') }}</label>
                                    <div class="input-group">
                                        <input type="password"
                                            name="password"
                                            id="password"
                                            class="form-control auth-control auth-password-input"
                                            required
                                            autocomplete="current-password"
                                            placeholder="Password">
                                        <button class="btn auth-password-toggle"
                                            type="button"
                                            data-toggle-password="password"
                                            aria-label="{{ __('Show password') }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="auth-remember">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" name="remember" type="checkbox" id="remember">
                                        <label class="form-check-label text-muted" for="remember">
                                            {{ __('Remember me') }}
                                        </label>
                                    </div>
                                    <span class="small text-muted">
                                        <i class="fas fa-shield-alt me-1" style="color: var(--auth-gold);"></i>{{ __('Secure session') }}
                                    </span>
                                </div>

                                <button type="submit" class="btn auth-submit w-100 mb-3" id="login-submit">
                                    {{ __('Login Now') }} <i class="fas fa-arrow-right ms-2"></i>
                                </button>

                                <div class="auth-login-note">
                                    <i class="fas fa-user-shield"></i>
                                    <span>{{ __('For your safety, unverified accounts are asked to complete email OTP verification before entering the account area.') }}</span>
                                </div>
                            </form>

                            <div class="auth-mini-row" aria-label="{{ __('Login benefits') }}">
                                <span class="auth-mini-chip"><i class="fas fa-check-circle"></i>{{ __('Fast') }}</span>
                                <span class="auth-mini-chip"><i class="fas fa-lock"></i>{{ __('Private') }}</span>
                                <span class="auth-mini-chip"><i class="fas fa-leaf"></i>{{ __('Natural') }}</span>
                            </div>

                            <div class="auth-divider">{{ __('New here?') }}</div>

                            <p class="auth-register mb-0">
                                {{ __("Don't have an account?") }}
                                <a href="{{ route('register') }}">{{ __('Create One') }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
        button.addEventListener('click', function () {
            var target = document.getElementById(button.getAttribute('data-toggle-password'));
            var icon = button.querySelector('i');
            if (!target || !icon) return;

            var isPassword = target.getAttribute('type') === 'password';
            target.setAttribute('type', isPassword ? 'text' : 'password');
            icon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    });

    var form = document.getElementById('login-form');
    var submit = document.getElementById('login-submit');

    if (form && submit) {
        form.addEventListener('submit', function () {
            submit.disabled = true;
            submit.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>{{ __('Signing in...') }}';
        });
    }
});
</script>
@endpush
