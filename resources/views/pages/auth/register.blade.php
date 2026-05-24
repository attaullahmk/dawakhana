@extends('layouts.app')

@section('content')
    <style>
        .register-shell {
            --auth-primary: var(--primary);
            --auth-secondary: var(--secondary);
            --auth-ink: #17231c;
            --auth-muted: #6f756f;
            --auth-line: rgba(27, 67, 50, 0.14);
            --auth-soft: #f7f4ef;
            min-height: 100vh;
            background:
                radial-gradient(circle at 10% 15%, rgba(212, 168, 83, 0.18), transparent 28%),
                linear-gradient(145deg, #fbfaf7 0%, #f2eee7 100%);
            padding: 116px 0 64px;
        }

        .auth-panel {
            border: 1px solid var(--auth-line);
            border-radius: 28px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 28px 70px rgba(27, 67, 50, 0.16);
            animation: authRise 0.65s ease both;
        }

        .auth-story {
            position: relative;
            min-height: 100%;
            background:
                linear-gradient(180deg, rgba(27, 67, 50, 0.88), rgba(27, 67, 50, 0.94)),
                url('https://images.unsplash.com/photo-1471864190281-a93a3070b6de?auto=format&fit=crop&w=1200&q=80') center/cover;
            isolation: isolate;
        }

        .auth-story::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(145deg, rgba(212, 168, 83, 0.3), transparent 52%);
            z-index: -1;
        }

        .story-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255, 255, 255, 0.28);
            background: rgba(255, 255, 255, 0.12);
            border-radius: 999px;
            padding: 8px 13px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .story-list li {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-bottom: 18px;
            color: rgba(255, 255, 255, 0.84);
        }

        .story-list i {
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 30px;
            border-radius: 50%;
            background: rgba(212, 168, 83, 0.92);
            color: #fff;
            font-size: 0.8rem;
        }

        .trust-strip {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .trust-item {
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 14px;
        }

        .register-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--auth-primary);
            background: rgba(27, 67, 50, 0.08);
            border: 1px solid rgba(27, 67, 50, 0.12);
            border-radius: 999px;
            padding: 8px 13px;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .auth-title {
            position: relative;
            display: inline-block;
            color: #123524;
            background: linear-gradient(135deg, #0f3d2e 0%, #2f7d4f 48%, #c7962e 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 12px 28px rgba(27, 67, 50, 0.12);
        }

        .auth-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -9px;
            width: 82px;
            height: 4px;
            border-radius: 999px;
            background: linear-gradient(90deg, #2f7d4f, #d4a853);
            box-shadow: 0 8px 18px rgba(212, 168, 83, 0.28);
        }

        .social-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .btn-auth-social {
            border: 1px solid var(--auth-line);
            background: #fff;
            color: var(--auth-ink);
            border-radius: 999px;
            padding: 12px 16px;
            font-weight: 700;
            transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .btn-auth-social:hover {
            border-color: var(--auth-primary);
            color: var(--auth-primary);
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(27, 67, 50, 0.12);
        }

        .divider-text {
            display: flex;
            align-items: center;
            gap: 14px;
            color: var(--auth-muted);
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .divider-text::before,
        .divider-text::after {
            content: '';
            height: 1px;
            flex: 1;
            background: var(--auth-line);
        }

        .input-field-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: var(--auth-primary);
            background: rgba(27, 67, 50, 0.08);
            pointer-events: none;
            z-index: 5;
            transition: transform 0.25s ease, background-color 0.25s ease, color 0.25s ease;
        }

        .form-control-icon {
            min-height: 52px;
            padding-left: 64px !important;
            border: 1px solid var(--auth-line) !important;
            background: #fff;
            color: var(--auth-ink);
            transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
        }

        .form-control-icon::placeholder {
            color: #a9ada8;
        }

        .form-control-icon:focus {
            border-color: var(--auth-primary) !important;
            box-shadow: 0 0 0 4px rgba(27, 67, 50, 0.1) !important;
            background: #fff;
        }

        .form-control-icon:focus ~ .input-icon,
        .input-group:focus-within .input-icon {
            color: #fff;
            background: var(--auth-primary);
            transform: translateY(-50%) scale(1.05);
        }

        .input-group.auth-password {
            border: 1px solid var(--auth-line);
            border-radius: 999px;
            background: #fff;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .input-group.auth-password:focus-within {
            border-color: var(--auth-primary);
            box-shadow: 0 0 0 4px rgba(27, 67, 50, 0.1);
        }

        .input-group.auth-password .form-control {
            min-height: 52px;
            background: transparent;
            border: 0 !important;
            box-shadow: none !important;
        }

        .password-toggle {
            width: 52px;
            border: 0;
            background: transparent;
            color: var(--auth-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: color 0.25s ease, transform 0.25s ease;
        }

        .password-toggle:hover {
            color: var(--auth-secondary);
            transform: scale(1.08);
        }

        .field-feedback {
            min-height: 18px;
            margin-top: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .field-feedback.show {
            opacity: 1;
        }

        .field-feedback.success {
            color: var(--success);
        }

        .field-feedback.error {
            color: var(--danger);
        }

        .password-meter {
            display: none;
            margin-top: 10px;
        }

        .password-meter.show {
            display: block;
        }

        .strength-track {
            height: 7px;
            border-radius: 999px;
            overflow: hidden;
            background: #e5ded3;
        }

        .strength-fill {
            height: 100%;
            width: 0;
            border-radius: inherit;
            transition: width 0.28s ease, background-color 0.28s ease;
        }

        .strength-fill.weak { width: 33%; background: var(--danger); }
        .strength-fill.medium { width: 66%; background: #d99a1e; }
        .strength-fill.strong { width: 100%; background: var(--success); }

        .password-rules {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin-top: 10px;
            color: var(--auth-muted);
            font-size: 0.76rem;
        }

        .password-rules span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .password-rules span.valid {
            color: var(--success);
            font-weight: 700;
        }

        .btn-register {
            min-height: 54px;
            border: 0;
            background: linear-gradient(135deg, var(--auth-primary), var(--auth-secondary));
            position: relative;
            overflow: hidden;
            box-shadow: 0 14px 28px rgba(27, 67, 50, 0.22);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            inset: 0;
            transform: translateX(-100%);
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.26), transparent);
            transition: transform 0.55s ease;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 34px rgba(27, 67, 50, 0.28);
        }

        .btn-register:hover::before {
            transform: translateX(100%);
        }

        .secure-note {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            color: var(--auth-muted);
            background: var(--auth-soft);
            border: 1px solid var(--auth-line);
            border-radius: 16px;
            padding: 12px 14px;
            font-size: 0.82rem;
        }

        @keyframes authRise {
            from { opacity: 0; transform: translateY(22px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 991.98px) {
            .register-shell {
                padding: 92px 0 40px;
            }

            .auth-panel {
                border-radius: 22px;
            }
        }

        @media (max-width: 575.98px) {
            .register-shell {
                padding: 78px 0 24px;
            }

            .social-row,
            .password-rules,
            .trust-strip {
                grid-template-columns: 1fr;
            }

            .auth-panel {
                border-radius: 18px;
            }

            .form-control-icon {
                min-height: 50px;
            }
        }
    </style>

    <section class="register-shell">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-11">
                    <div class="auth-panel">
                        <div class="row g-0">
                            <div class="col-lg-5 d-none d-lg-flex">
                                <div class="auth-story text-white p-5 d-flex flex-column justify-content-between w-100">
                                    <div>
                                        <span class="story-badge mb-4">
                                            <i class="fas fa-crown"></i>
                                            Trusted Herbal Care
                                        </span>
                                        <h1 class="playfair display-5 mb-3">Start your natural wellness journey with Dawakhana.</h1>
                                        <p class="text-white-75 mb-5">Create your account to save herbal remedies, track orders, receive OTP-secured access, and enjoy a faster checkout experience.</p>

                                        <ul class="story-list list-unstyled mb-5">
                                            <li>
                                                <i class="fas fa-heart"></i>
                                                <span>Save trusted herbal products and remedies to your wishlist.</span>
                                            </li>
                                            <li>
                                                <i class="fas fa-truck-fast"></i>
                                                <span>Track your medicine and wellness orders from checkout to delivery.</span>
                                            </li>
                                            <li>
                                                <i class="fas fa-shield-halved"></i>
                                                <span>Verify your account with OTP and shop with more confidence.</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="trust-strip">
                                        <div class="trust-item">
                                            <div class="fw-bold h5 mb-0">24/7</div>
                                            <div class="small text-white-75">Care</div>
                                        </div>
                                        <div class="trust-item">
                                            <div class="fw-bold h5 mb-0">Fast</div>
                                            <div class="small text-white-75">Orders</div>
                                        </div>
                                        <div class="trust-item">
                                            <div class="fw-bold h5 mb-0">Safe</div>
                                            <div class="small text-white-75">OTP</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-7">
                                <div class="p-4 p-md-5">
                                    <div class="mb-4">
                                        <span class="register-kicker mb-3">
                                            <i class="fas fa-user-plus"></i>
                                            Fast signup
                                        </span>
                                        <h2 class="playfair auth-title mb-3">Create your Dawakhana account</h2>
                                        <p class="text-muted mb-0">Enter your details below. After signup, we will send an OTP to verify your email.</p>
                                    </div>

                                    @if($errors->any())
                                        <div class="alert alert-danger mb-4 rounded-4 small">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="social-row mb-4">
                                        <a href="#" class="btn btn-auth-social d-flex align-items-center justify-content-center gap-2">
                                            <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="20" height="20" alt="Google">
                                            Google
                                        </a>
                                        <a href="#" class="btn btn-auth-social d-flex align-items-center justify-content-center gap-2">
                                            <i class="fab fa-facebook-f"></i>
                                            Facebook
                                        </a>
                                    </div>

                                    <div class="divider-text mb-4">or register with email</div>

                                    <form action="{{ route('register') }}" method="POST" novalidate>
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                                <label class="form-label text-muted fw-bold small text-uppercase mb-2" for="first_name">First Name</label>
                                                <div class="input-field-wrapper">
                                                    <input type="text" id="first_name" name="first_name" class="form-control rounded-pill shadow-none form-control-icon @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required autocomplete="given-name" placeholder="John">
                                                    <span class="input-icon"><i class="fas fa-user"></i></span>
                                                </div>
                                                <div class="field-feedback" id="feedback-first_name"></div>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="form-label text-muted fw-bold small text-uppercase mb-2" for="last_name">Last Name</label>
                                                <div class="input-field-wrapper">
                                                    <input type="text" id="last_name" name="last_name" class="form-control rounded-pill shadow-none form-control-icon @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required autocomplete="family-name" placeholder="Doe">
                                                    <span class="input-icon"><i class="fas fa-id-badge"></i></span>
                                                </div>
                                                <div class="field-feedback" id="feedback-last_name"></div>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label text-muted fw-bold small text-uppercase mb-2" for="email">Email Address</label>
                                                <div class="input-field-wrapper">
                                                    <input type="email" id="email" name="email" class="form-control rounded-pill shadow-none form-control-icon @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" placeholder="john@example.com">
                                                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                                                </div>
                                                <div class="field-feedback" id="feedback-email"></div>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label text-muted fw-bold small text-uppercase mb-2" for="password">Password</label>
                                                <div class="input-field-wrapper">
                                                    <div class="input-group auth-password overflow-hidden">
                                                        <input type="password" name="password" id="password" class="form-control form-control-icon" required autocomplete="new-password" placeholder="Create a strong password">
                                                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                                                        <button class="password-toggle" type="button" data-toggle-password="password" aria-label="Show password">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="password-meter" id="strength-container">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="small fw-bold text-muted">Password strength</span>
                                                        <span class="small fw-bold" id="strength-text">Weak</span>
                                                    </div>
                                                    <div class="strength-track">
                                                        <div class="strength-fill" id="strength-fill"></div>
                                                    </div>
                                                    <div class="password-rules" id="password-rules">
                                                        <span data-rule="length"><i class="fas fa-circle"></i> 8+ characters</span>
                                                        <span data-rule="case"><i class="fas fa-circle"></i> Upper & lower case</span>
                                                        <span data-rule="number"><i class="fas fa-circle"></i> Number</span>
                                                        <span data-rule="symbol"><i class="fas fa-circle"></i> Symbol</span>
                                                    </div>
                                                </div>
                                                <div class="field-feedback" id="feedback-password"></div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                                    <label class="form-check-label text-muted small" for="terms">
                                                        I agree to the <a href="#" class="text-primary-custom text-decoration-none fw-bold">Terms of Service</a> and <a href="#" class="text-primary-custom text-decoration-none fw-bold">Privacy Policy</a>.
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" class="btn btn-register btn-lg w-100 rounded-pill py-3 fw-bold text-white">
                                                    <span class="position-relative d-inline-flex align-items-center gap-2">
                                                        Create Account
                                                        <i class="fas fa-arrow-right"></i>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="secure-note mt-4">
                                        <i class="fas fa-lock text-primary-custom mt-1"></i>
                                        <span>Your information is used to create your account, send OTP verification, personalize shopping, and keep checkout secure.</span>
                                    </div>

                                    <p class="text-center text-muted mb-0 mt-4">
                                        Already have an account?
                                        <a href="{{ route('login') }}" class="text-primary-custom fw-bold text-decoration-none">Login Here</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
            button.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
        });
    });

    var passwordInput = document.getElementById('password');
    var strengthContainer = document.getElementById('strength-container');
    var strengthFill = document.getElementById('strength-fill');
    var strengthText = document.getElementById('strength-text');
    var passwordRules = document.getElementById('password-rules');

    if (passwordInput) {
        passwordInput.addEventListener('input', function () {
            var password = this.value;
            if (!strengthContainer || !strengthFill || !strengthText || !passwordRules) return;

            if (password.length === 0) {
                strengthContainer.classList.remove('show');
                strengthFill.className = 'strength-fill';
                strengthText.textContent = 'Weak';
                return;
            }

            strengthContainer.classList.add('show');

            var rules = {
                length: password.length >= 8,
                case: /[a-z]/.test(password) && /[A-Z]/.test(password),
                number: /\d/.test(password),
                symbol: /[^A-Za-z0-9]/.test(password)
            };

            Object.keys(rules).forEach(function (ruleName) {
                var rule = passwordRules.querySelector('[data-rule="' + ruleName + '"]');
                if (!rule) return;
                rule.classList.toggle('valid', rules[ruleName]);
                rule.querySelector('i').className = rules[ruleName] ? 'fas fa-check-circle' : 'fas fa-circle';
            });

            var score = Object.keys(rules).filter(function (ruleName) {
                return rules[ruleName];
            }).length;

            var level = 'weak';
            if (score >= 4) level = 'strong';
            else if (score >= 2) level = 'medium';

            strengthFill.className = 'strength-fill ' + level;
            strengthText.className = 'small fw-bold text-capitalize ' + level;
            strengthText.textContent = level;
        });
    }

    var fields = {
        first_name: { regex: /^[a-zA-Z\s'-]{2,}$/, message: 'Please enter at least 2 letters.' },
        last_name: { regex: /^[a-zA-Z\s'-]{2,}$/, message: 'Please enter at least 2 letters.' },
        email: { regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, message: 'Please enter a valid email address.' }
    };

    Object.keys(fields).forEach(function (fieldId) {
        var input = document.getElementById(fieldId);
        if (!input) return;

        input.addEventListener('blur', function () {
            validateField(fieldId, input.value, fields[fieldId]);
        });

        input.addEventListener('input', function () {
            var feedback = document.getElementById('feedback-' + fieldId);
            if (feedback) feedback.classList.remove('show');
            input.classList.remove('is-valid', 'is-invalid');
        });
    });

    function validateField(fieldId, value, rule) {
        var input = document.getElementById(fieldId);
        var feedback = document.getElementById('feedback-' + fieldId);
        if (!input || !feedback) return;

        if (value.trim() === '') {
            input.classList.remove('is-valid', 'is-invalid');
            feedback.classList.remove('show');
            return;
        }

        if (rule.regex.test(value.trim())) {
            input.classList.add('is-valid');
            input.classList.remove('is-invalid');
            feedback.className = 'field-feedback show success';
            feedback.innerHTML = '<i class="fas fa-check-circle"></i> Looks good.';
        } else {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            feedback.className = 'field-feedback show error';
            feedback.innerHTML = '<i class="fas fa-times-circle"></i> ' + rule.message;
        }
    }
});
</script>
@endpush
