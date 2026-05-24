@extends('layouts.app')

@push('styles')
<style>
:root {
    --otp-green: #17382b;
    --otp-green-light: #2d6a4f;
    --otp-gold: #c8a165;
    --otp-gold-light: #e2c08d;
    --otp-ink: #1f2d26;
    --otp-muted: #6f7d73;
    --otp-line: rgba(26, 60, 46, 0.12);
    --otp-soft: #f8f5f0;
    --otp-shadow: 0 24px 58px rgba(26, 60, 46, 0.14);
}

.otp-page {
    min-height: 100vh;
    overflow: hidden;
    background:
        radial-gradient(circle at 8% 12%, rgba(45, 106, 79, 0.1), transparent 28%),
        radial-gradient(circle at 92% 18%, rgba(200, 161, 101, 0.13), transparent 24%),
        linear-gradient(180deg, #fff 0%, var(--otp-soft) 100%);
}

.otp-hero {
    position: relative;
    min-height: 330px;
    display: flex;
    align-items: center;
    margin-top: 50px;
    color: #fff;
    background:
        linear-gradient(105deg, rgba(12, 24, 18, 0.94) 0%, rgba(23, 56, 43, 0.84) 58%, rgba(45, 106, 79, 0.58) 100%),
        url('https://images.unsplash.com/photo-1585435557343-3b092031a831?q=80&w=1920&auto=format&fit=crop');
    background-size: cover;
    background-position: center;
}

.otp-hero::after {
    content: '';
    position: absolute;
    inset: auto 0 0;
    height: 88px;
    background: linear-gradient(180deg, transparent, rgba(248, 245, 240, 0.98));
}

.otp-hero-content {
    position: relative;
    z-index: 2;
    padding: 88px 0 112px;
}

.otp-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: 1px solid rgba(226, 192, 141, 0.42);
    border-radius: 50px;
    background: rgba(200, 161, 101, 0.14);
    color: var(--otp-gold-light);
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 2.2px;
    text-transform: uppercase;
    margin-bottom: 18px;
}

.otp-hero h1,
.otp-title {
    font-family: 'Playfair Display', serif;
    font-weight: 800;
    letter-spacing: 0;
}

.otp-hero p {
    max-width: 640px;
    color: rgba(255, 255, 255, 0.84);
    line-height: 1.8;
}

.otp-shell {
    position: relative;
    z-index: 5;
    margin-top: -64px;
    padding-bottom: 82px;
}

.otp-card {
    position: relative;
    overflow: hidden;
    border: 1px solid var(--otp-line);
    border-radius: 8px;
    background: linear-gradient(180deg, #fff 0%, #fbf8f1 100%);
    box-shadow: var(--otp-shadow);
    animation: otpFade 0.55s ease both;
}

.otp-card::before {
    content: '';
    position: absolute;
    inset: 0 0 auto;
    height: 5px;
    background: linear-gradient(90deg, var(--otp-gold), var(--otp-green-light));
}

.otp-card-inner {
    padding: clamp(28px, 5vw, 48px);
}

.otp-icon {
    width: 72px;
    height: 72px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #fff;
    background: linear-gradient(135deg, var(--otp-green), var(--otp-green-light));
    box-shadow: 0 18px 34px rgba(26, 60, 46, 0.22);
    margin-bottom: 20px;
}

.otp-title {
    position: relative;
    display: inline-block;
    color: #123524;
    background: linear-gradient(135deg, #0f3d2e 0%, #2f7d4f 48%, #c7962e 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    padding-bottom: 12px;
    margin-bottom: 16px;
    text-shadow: 0 12px 28px rgba(27, 67, 50, 0.12);
}

.otp-title::after {
    content: '';
    position: absolute;
    left: 50%;
    bottom: 0;
    width: 82px;
    height: 4px;
    border-radius: 999px;
    background: linear-gradient(90deg, #2f7d4f, #d4a853);
    box-shadow: 0 8px 18px rgba(212, 168, 83, 0.28);
    transform: translateX(-50%);
}

.otp-copy {
    color: var(--otp-muted);
    line-height: 1.75;
}

.otp-email-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    max-width: 100%;
    border: 1px solid rgba(200, 161, 101, 0.26);
    border-radius: 50px;
    color: var(--otp-green);
    background: rgba(200, 161, 101, 0.12);
    padding: 9px 14px;
    font-size: 0.82rem;
    font-weight: 800;
    word-break: break-word;
}

.otp-alert {
    border: 0;
    border-radius: 8px;
    box-shadow: 0 10px 24px rgba(26, 60, 46, 0.08);
}

.otp-input-grid {
    display: grid;
    grid-template-columns: repeat(6, minmax(0, 1fr));
    gap: 10px;
}

.otp-input {
    width: 100%;
    aspect-ratio: 1 / 1.06;
    min-height: 54px;
    border: 1px solid rgba(26, 60, 46, 0.14) !important;
    border-radius: 8px !important;
    color: var(--otp-ink) !important;
    background: #fff !important;
    font-size: clamp(1.25rem, 4vw, 1.65rem);
    font-weight: 900;
    text-align: center;
    box-shadow: none !important;
    transition: border-color 0.22s ease, box-shadow 0.22s ease, transform 0.22s ease;
}

.otp-input:focus {
    border-color: rgba(200, 161, 101, 0.72) !important;
    box-shadow: 0 0 0 4px rgba(200, 161, 101, 0.14) !important;
    transform: translateY(-2px);
}

.otp-submit {
    min-height: 56px;
    border: 0;
    border-radius: 8px;
    color: #fff;
    background: linear-gradient(135deg, var(--otp-green), var(--otp-green-light));
    font-weight: 900;
    box-shadow: 0 16px 34px rgba(26, 60, 46, 0.22);
    transition: transform 0.24s ease, box-shadow 0.24s ease, filter 0.24s ease;
}

.otp-submit:hover,
.otp-submit:focus {
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 24px 46px rgba(26, 60, 46, 0.28);
    filter: brightness(1.04);
}

.otp-resend-box {
    border: 1px solid rgba(200, 161, 101, 0.24);
    border-radius: 8px;
    color: var(--otp-muted);
    background: rgba(200, 161, 101, 0.1);
    padding: 14px;
}

.otp-resend-btn {
    border: 0;
    color: var(--otp-green);
    background: transparent;
    font-weight: 900;
    padding: 0;
}

.otp-resend-btn:hover {
    color: var(--otp-gold);
}

.otp-mini-row {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 10px;
    margin-top: 22px;
}

.otp-mini-chip {
    min-height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    border: 1px solid rgba(200, 161, 101, 0.24);
    border-radius: 8px;
    color: var(--otp-green);
    background: rgba(200, 161, 101, 0.12);
    font-size: 0.7rem;
    font-weight: 900;
}

@keyframes otpFade {
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
    .otp-hero {
        margin-top: 0;
        min-height: auto;
    }

    .otp-hero-content {
        padding: 108px 0 94px;
    }

    .otp-shell {
        margin-top: 0;
        padding-top: 48px;
    }
}

@media (max-width: 575.98px) {
    .otp-hero h1 {
        font-size: 2.4rem;
    }

    .otp-input-grid {
        gap: 7px;
    }

    .otp-input {
        min-height: 46px;
        border-radius: 7px !important;
    }

    .otp-mini-row {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<main class="otp-page">
    <section class="otp-hero">
        <div class="container">
            <div class="otp-hero-content">
                <span class="otp-badge">
                    <i class="fas fa-shield-halved"></i>
                    {{ __('Email Security') }}
                </span>
                <h1 class="display-4 mb-3">{{ __('Verify Your Email') }}</h1>
                <p class="lead mb-0">
                    {{ __('Enter the 6-digit code sent to your email so we can activate your Dawakhana account securely.') }}
                </p>
            </div>
        </div>
    </section>

    <section class="otp-shell">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <div class="otp-card">
                        <div class="otp-card-inner text-center">
                            <div class="otp-icon">
                                <i class="fas fa-envelope-open-text fa-2x"></i>
                            </div>

                            <h2 class="otp-title h1">{{ __('Enter OTP') }}</h2>
                            <p class="otp-copy mb-3">
                                {{ __("We've sent a 6-digit verification code to") }}
                            </p>

                            <div class="otp-email-pill mb-4">
                                <i class="fas fa-at"></i>
                                <span>{{ session('email') }}</span>
                            </div>

                            @if(session('error'))
                                <div class="alert alert-danger otp-alert small mb-4 text-start">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success otp-alert small mb-4 text-start">
                                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger otp-alert small mb-4 text-start">
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('register.verify') }}" method="POST" id="otp-form">
                                @csrf
                                <input type="hidden" name="email" value="{{ session('email') }}">

                                <div class="mb-4">
                                    <div class="otp-input-grid" id="otp-inputs" aria-label="{{ __('OTP code') }}">
                                        @for($i = 0; $i < 6; $i++)
                                            <input type="text" name="otp[]" class="form-control otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" required aria-label="{{ __('OTP digit') }} {{ $i + 1 }}">
                                        @endfor
                                    </div>
                                </div>

                                <button type="submit" class="btn otp-submit w-100" id="otp-submit">
                                    {{ __('Verify & Activate') }} <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </form>

                            <div class="otp-mini-row" aria-label="{{ __('Verification benefits') }}">
                                <span class="otp-mini-chip"><i class="fas fa-lock"></i>{{ __('Secure') }}</span>
                                <span class="otp-mini-chip"><i class="fas fa-clock"></i>{{ __('10 min') }}</span>
                                <span class="otp-mini-chip"><i class="fas fa-leaf"></i>{{ __('Dawakhana') }}</span>
                            </div>

                            <div class="otp-resend-box mt-4">
                                <span class="small">{{ __("Didn't receive the code?") }}</span>
                                <form action="{{ route('register.resend') }}" method="POST" class="d-inline" id="resend-form">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ session('email') }}">
                                    <button type="submit" class="otp-resend-btn small ms-1" id="resend-submit">
                                        {{ __('Resend OTP') }}
                                    </button>
                                </form>
                            </div>
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
    var inputs = Array.prototype.slice.call(document.querySelectorAll('#otp-inputs input'));
    var otpForm = document.getElementById('otp-form');
    var otpSubmit = document.getElementById('otp-submit');
    var resendForm = document.getElementById('resend-form');
    var resendSubmit = document.getElementById('resend-submit');

    inputs.forEach(function (input, index) {
        input.addEventListener('input', function (event) {
            var value = event.target.value.replace(/\D/g, '').slice(0, 1);
            event.target.value = value;

            if (value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', function (event) {
            if (event.key === 'Backspace' && event.target.value === '' && index > 0) {
                inputs[index - 1].focus();
            }
        });

        input.addEventListener('paste', function (event) {
            event.preventDefault();
            var pasted = (event.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
            if (!pasted) return;

            inputs.forEach(function (otpInput, inputIndex) {
                otpInput.value = pasted[inputIndex] || '';
            });

            var nextIndex = Math.min(pasted.length, inputs.length) - 1;
            if (nextIndex >= 0) {
                inputs[nextIndex].focus();
            }
        });
    });

    if (otpForm && otpSubmit) {
        otpForm.addEventListener('submit', function () {
            otpSubmit.disabled = true;
            otpSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>{{ __('Verifying...') }}';
        });
    }

    if (resendForm && resendSubmit) {
        resendForm.addEventListener('submit', function () {
            resendSubmit.disabled = true;
            resendSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>{{ __('Sending...') }}';
        });
    }
});
</script>
@endpush
