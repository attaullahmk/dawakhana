@extends('layouts.app')

@push('styles')
<style>
:root {
    --contact-green: #17382b;
    --contact-green-light: #2d6a4f;
    --contact-gold: #c8a165;
    --contact-gold-light: #e2c08d;
    --contact-ink: #1f2d26;
    --contact-muted: #6f7d73;
    --contact-line: rgba(26, 60, 46, 0.12);
    --contact-soft: #f8f5f0;
    --contact-shadow: 0 18px 46px rgba(26, 60, 46, 0.12);
}

.contact-page {
    overflow: hidden;
    background:
        radial-gradient(circle at 8% 14%, rgba(45,106,79,0.08), transparent 28%),
        linear-gradient(180deg, #fff 0%, var(--contact-soft) 100%);
}

.contact-hero {
    position: relative;
    min-height: 430px;
    display: flex;
    align-items: center;
    margin-top: 50px;
    color: #fff;
    background-image:
        linear-gradient(105deg, rgba(12,24,18,0.94) 0%, rgba(23,56,43,0.78) 58%, rgba(23,56,43,0.42) 100%),
        url('https://images.unsplash.com/photo-1611078489935-0cb964de46d6?q=80&w=1920&auto=format&fit=crop');
    background-size: cover;
    background-position: center;
}

.contact-hero::after {
    content: '';
    position: absolute;
    inset: auto 0 0;
    height: 90px;
    background: linear-gradient(180deg, transparent, rgba(248,245,240,0.96));
}

.contact-hero-content {
    position: relative;
    z-index: 2;
    max-width: 720px;
    padding: 86px 0 120px;
}

.contact-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: 1px solid rgba(226,192,141,0.42);
    border-radius: 50px;
    background: rgba(200,161,101,0.14);
    color: var(--contact-gold-light);
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 2.4px;
    text-transform: uppercase;
    margin-bottom: 20px;
}

.contact-hero h1 {
    font-family: 'Playfair Display', serif;
    font-weight: 800;
    line-height: 1.08;
    letter-spacing: 0;
    margin-bottom: 18px;
}

.contact-hero p {
    max-width: 620px;
    color: rgba(255,255,255,0.84);
    line-height: 1.85;
}

.contact-stat-strip {
    position: relative;
    z-index: 5;
    margin-top: -56px;
}

.contact-stat-panel {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1px;
    overflow: hidden;
    border: 1px solid var(--contact-line);
    border-radius: 8px;
    background: var(--contact-line);
    box-shadow: var(--contact-shadow);
}

.contact-stat {
    display: flex;
    align-items: center;
    gap: 14px;
    min-height: 104px;
    padding: 22px;
    background: #fff;
}

.contact-stat i,
.contact-method-icon,
.contact-promise i {
    width: 46px;
    height: 46px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 auto;
    border-radius: 50%;
    color: var(--contact-green);
    background: rgba(200,161,101,0.18);
}

.contact-stat strong {
    display: block;
    color: var(--contact-ink);
    font-size: 0.96rem;
}

.contact-stat span {
    display: block;
    color: var(--contact-muted);
    font-size: 0.82rem;
    margin-top: 2px;
}

.contact-shell {
    padding: 80px 0;
}

.contact-section-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--contact-green);
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 2.2px;
    text-transform: uppercase;
    padding: 7px 15px;
    border-radius: 50px;
    border: 1px solid rgba(200,161,101,0.26);
    background: rgba(200,161,101,0.12);
    margin-bottom: 14px;
}

.contact-title {
    font-family: 'Playfair Display', serif;
    color: var(--contact-green);
    font-weight: 800;
    line-height: 1.15;
}

.contact-copy {
    color: var(--contact-muted);
    line-height: 1.8;
}

.contact-info-panel,
.contact-form-card,
.contact-map-card,
.contact-promise,
.contact-method {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    border: 1px solid var(--contact-line);
    background: #fff;
    box-shadow: var(--contact-shadow);
}

.contact-info-panel {
    padding: 30px;
    height: 100%;
}

.contact-method {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 18px;
    box-shadow: none;
    transition: transform 0.28s ease, border-color 0.28s ease, box-shadow 0.28s ease;
}

.contact-method + .contact-method {
    margin-top: 14px;
}

.contact-method::before {
    content: '';
    position: absolute;
    top: 14px;
    bottom: 14px;
    left: 0;
    width: 4px;
    border-radius: 0 8px 8px 0;
    background: linear-gradient(180deg, var(--contact-gold), var(--contact-green-light));
    transform: scaleY(0.28);
    transition: transform 0.3s ease;
}

.contact-method:hover {
    transform: translateX(4px);
    border-color: rgba(200,161,101,0.42);
    box-shadow: 0 14px 34px rgba(26,60,46,0.1);
}

.contact-method:hover::before {
    transform: scaleY(1);
}

.contact-method:hover .contact-method-icon {
    color: #fff;
    background: var(--contact-green);
    transform: rotate(-8deg) scale(1.06);
}

.contact-method-icon {
    transition: transform 0.28s ease, background 0.28s ease, color 0.28s ease;
}

/* Ensure icon anchors inherit the parent color so icons remain visible on hover */
.contact-method-icon a {
    color: inherit;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    text-decoration: none;
    transition: transform 0.28s ease, background 0.28s ease, color 0.28s ease, box-shadow 0.28s ease;
}

.contact-method-icon a i {
    color: inherit;
}

/* Strong visible hover/focus so icons don't disappear on background change */
.contact-method-icon a:hover,
.contact-method-icon a:focus {
    color: #fff;
    background: linear-gradient(135deg, var(--contact-green), var(--contact-green-light));
    transform: rotate(-8deg) scale(1.08);
    box-shadow: 0 12px 34px rgba(23,56,43,0.18);
    border-radius: 50%;
}

.contact-section-label a {
    color: inherit;
    text-decoration: none;
    transition: color 0.22s ease, transform 0.22s ease;
}

.contact-section-label a:hover,
.contact-section-label a:focus {
    color: var(--contact-gold-light);
    transform: translateY(-2px);
}

.contact-method h5 {
    color: var(--contact-ink);
    margin-bottom: 5px;
}

.contact-method p,
.contact-method a {
    color: var(--contact-muted);
    line-height: 1.65;
    text-decoration: none;
    overflow-wrap: anywhere;
}

.contact-method a:hover {
    color: var(--contact-green);
}

.contact-map-card {
    margin-top: 18px;
    padding: 22px;
    background:
        linear-gradient(135deg, rgba(23,56,43,0.95), rgba(45,106,79,0.9)),
        linear-gradient(90deg, rgba(200,161,101,0.18), transparent);
    color: #fff;
}

.contact-map-card p {
    color: rgba(255,255,255,0.78);
    line-height: 1.7;
}

.contact-map-link {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: var(--contact-green) !important;
    background: linear-gradient(135deg, var(--contact-gold), var(--contact-gold-light));
    border-radius: 50px;
    padding: 12px 18px;
    font-weight: 900;
    text-decoration: none;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.contact-map-link:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 28px rgba(200,161,101,0.3);
}

.contact-form-card {
    padding: clamp(24px, 4vw, 42px);
    background:
        linear-gradient(180deg, #fff 0%, #fbf8f1 100%);
}

.contact-form-card::after,
.contact-map-card::after {
    content: '';
    position: absolute;
    top: -60%;
    left: -70%;
    width: 42%;
    height: 230%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.42), transparent);
    transform: rotate(18deg);
    opacity: 0;
    transition: left 0.72s ease, opacity 0.32s ease;
    pointer-events: none;
}

.contact-form-card:hover::after,
.contact-map-card:hover::after {
    left: 128%;
    opacity: 1;
}

.contact-field label {
    color: var(--contact-green);
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.contact-control {
    min-height: 52px;
    border: 1px solid rgba(26,60,46,0.12) !important;
    border-radius: 8px !important;
    background: #fff !important;
    color: var(--contact-ink) !important;
    padding: 12px 16px !important;
    box-shadow: none !important;
    transition: border-color 0.22s ease, box-shadow 0.22s ease, transform 0.22s ease;
}

.contact-control:focus {
    border-color: rgba(200,161,101,0.72) !important;
    box-shadow: 0 0 0 4px rgba(200,161,101,0.14) !important;
    transform: translateY(-1px);
}

textarea.contact-control {
    min-height: 150px;
    resize: vertical;
}

.contact-submit {
    min-height: 56px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(135deg, var(--contact-green), var(--contact-green-light));
    color: #fff;
    font-weight: 900;
    letter-spacing: 0.3px;
    box-shadow: 0 16px 34px rgba(26,60,46,0.22);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.contact-submit:hover {
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 24px 46px rgba(26,60,46,0.28);
}

.contact-submit i {
    transition: transform 0.25s ease;
}

.contact-submit:hover i {
    transform: translateX(4px);
}

.contact-alert {
    border: 0;
    border-radius: 8px;
    padding: 14px 16px;
    box-shadow: 0 10px 24px rgba(26,60,46,0.08);
}

.contact-promises {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
    margin-top: 34px;
}

.contact-promise {
    padding: 22px;
    box-shadow: 0 10px 28px rgba(26,60,46,0.08);
    transition: transform 0.28s ease, border-color 0.28s ease, box-shadow 0.28s ease;
}

.contact-promise:hover {
    transform: translateY(-7px);
    border-color: rgba(200,161,101,0.42);
    box-shadow: var(--contact-shadow);
}

.contact-promise:hover i {
    color: #fff;
    background: var(--contact-green);
}

.contact-promise h5 {
    color: var(--contact-green);
    margin: 16px 0 8px;
}

.contact-promise p {
    color: var(--contact-muted);
    line-height: 1.65;
}

.contact-floating-actions {
    position: fixed;
    right: 22px;
    bottom: 22px;
    z-index: 1040;
    display: grid;
    gap: 10px;
    opacity: 0;
    transform: translateY(18px);
    pointer-events: none;
    transition: opacity 0.28s ease, transform 0.28s ease;
}

.contact-floating-actions.is-visible {
    opacity: 1;
    transform: translateY(0);
    pointer-events: auto;
}

.contact-floating-actions a {
    width: 48px;
    height: 48px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #fff;
    background: linear-gradient(135deg, var(--contact-green), var(--contact-green-light));
    border: 1px solid rgba(226,192,141,0.38);
    box-shadow: 0 14px 34px rgba(26,60,46,0.2);
    text-decoration: none;
    transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
}

.contact-floating-actions a:hover {
    color: var(--contact-green);
    background: linear-gradient(135deg, var(--contact-gold), var(--contact-gold-light));
    transform: translateY(-4px) scale(1.04);
    box-shadow: 0 20px 42px rgba(26,60,46,0.25);
}

.contact-copy-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 10px;
}

.contact-mini-action {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border: 1px solid rgba(26,60,46,0.12);
    border-radius: 50px;
    background: #fff;
    color: var(--contact-green);
    padding: 7px 11px;
    font-size: 0.75rem;
    font-weight: 900;
    letter-spacing: 0.6px;
    text-transform: uppercase;
    transition: transform 0.22s ease, border-color 0.22s ease, background 0.22s ease, color 0.22s ease;
}

.contact-mini-action:hover {
    transform: translateY(-2px);
    border-color: rgba(200,161,101,0.48);
    background: var(--contact-green);
    color: #fff;
}

.contact-preferences {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 10px;
    margin-bottom: 20px;
}

.contact-preference {
    min-height: 48px;
    border: 1px solid rgba(26,60,46,0.12);
    border-radius: 8px;
    background: #fff;
    color: var(--contact-green);
    font-size: 0.8rem;
    font-weight: 900;
    transition: transform 0.22s ease, border-color 0.22s ease, background 0.22s ease, color 0.22s ease, box-shadow 0.22s ease;
}

.contact-preference:hover,
.contact-preference.is-active {
    transform: translateY(-3px);
    border-color: rgba(200,161,101,0.5);
    background: var(--contact-green);
    color: #fff;
    box-shadow: 0 12px 26px rgba(26,60,46,0.14);
}

.contact-form-tools {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 10px;
}

.contact-counter {
    color: var(--contact-muted);
    font-size: 0.78rem;
    font-weight: 800;
}

.contact-counter.is-warning {
    color: #a97825;
}

.contact-counter.is-danger {
    color: #b23b3b;
}

.contact-response-note {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--contact-muted);
    font-size: 0.82rem;
}

.contact-advanced-section {
    margin-top: 34px;
    display: grid;
    grid-template-columns: 0.95fr 1.05fr;
    gap: 18px;
}

.contact-process-card,
.contact-faq-card {
    position: relative;
    overflow: hidden;
    border: 1px solid var(--contact-line);
    border-radius: 8px;
    background: #fff;
    box-shadow: 0 12px 32px rgba(26,60,46,0.08);
    padding: 24px;
}

.contact-process-step {
    display: grid;
    grid-template-columns: 42px 1fr;
    gap: 14px;
    align-items: start;
    position: relative;
}

.contact-process-step + .contact-process-step {
    margin-top: 18px;
}

.contact-process-step + .contact-process-step::before {
    content: '';
    position: absolute;
    top: -18px;
    left: 20px;
    width: 1px;
    height: 18px;
    background: rgba(200,161,101,0.45);
}

.contact-process-step span {
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(200,161,101,0.16);
    color: var(--contact-green);
    font-weight: 900;
}

.contact-process-step strong {
    display: block;
    color: var(--contact-ink);
    margin-bottom: 3px;
}

.contact-process-step small {
    color: var(--contact-muted);
    line-height: 1.55;
}

.contact-faq-item {
    border: 1px solid rgba(26,60,46,0.1);
    border-radius: 8px;
    overflow: hidden;
    background: #fff;
}

.contact-faq-item + .contact-faq-item {
    margin-top: 10px;
}

.contact-faq-toggle {
    width: 100%;
    min-height: 54px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    border: 0;
    background: #fff;
    color: var(--contact-green);
    padding: 14px 16px;
    font-weight: 900;
    text-align: left;
}

.contact-faq-toggle i {
    transition: transform 0.25s ease;
}

.contact-faq-item.is-open .contact-faq-toggle i {
    transform: rotate(180deg);
}

.contact-faq-body {
    max-height: 0;
    overflow: hidden;
    color: var(--contact-muted);
    line-height: 1.7;
    padding: 0 16px;
    transition: max-height 0.28s ease, padding 0.28s ease;
}

.contact-faq-item.is-open .contact-faq-body {
    max-height: 180px;
    padding: 0 16px 16px;
}

.contact-toast {
    position: fixed;
    left: 50%;
    bottom: 24px;
    z-index: 1060;
    min-width: 220px;
    max-width: calc(100vw - 32px);
    padding: 12px 16px;
    border-radius: 50px;
    background: var(--contact-green);
    color: #fff;
    font-weight: 800;
    text-align: center;
    box-shadow: 0 18px 44px rgba(26,60,46,0.24);
    opacity: 0;
    transform: translate(-50%, 14px);
    pointer-events: none;
    transition: opacity 0.24s ease, transform 0.24s ease;
}

.contact-toast.is-visible {
    opacity: 1;
    transform: translate(-50%, 0);
}

@media (max-width: 991.98px) {
    .contact-stat-panel,
    .contact-promises,
    .contact-advanced-section {
        grid-template-columns: 1fr;
    }

    .contact-preferences {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .contact-hero {
        margin-top: 0;
        min-height: auto;
    }

    .contact-hero-content {
        padding: 110px 0 96px;
    }

    .contact-stat-strip {
        margin-top: 0;
    }
}

@media (max-width: 767.98px) {
    .contact-shell {
        padding: 54px 0;
    }

    .contact-hero h1 {
        font-size: 2.55rem;
    }

    .contact-info-panel {
        padding: 22px;
    }

    .contact-method {
        padding: 16px;
    }

    .contact-floating-actions {
        right: 14px;
        bottom: 14px;
    }

    .contact-floating-actions a {
        width: 44px;
        height: 44px;
    }

    .contact-preferences {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
@php
    $contactAddress = $globalSettings['site_address'] ?? 'Dawakhana, Pakistan';
    $contactPhone = $globalSettings['site_phone'] ?? '1-800-DAWAKHANA';
    $contactEmail = $globalSettings['site_email'] ?? 'hello@dawakhana.com';
    $mapUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($contactAddress);
@endphp

<main class="contact-page">
    <div class="contact-toast" id="contact-toast" aria-live="polite"></div>

    <div class="contact-floating-actions" id="contact-floating-actions" aria-label="{{ __('Quick contact actions') }}">
        <a href="mailto:{{ $contactEmail }}" aria-label="{{ __('Email us') }}">
            <i class="fas fa-envelope"></i>
        </a>
        <a href="tel:{{ preg_replace('/\s+/', '', $contactPhone) }}" aria-label="{{ __('Call us') }}">
            <i class="fas fa-phone"></i>
        </a>
        <a href="{{ $mapUrl }}" target="_blank" rel="noopener" aria-label="{{ __('Open map') }}">
            <i class="fas fa-map-marker-alt"></i>
        </a>
    </div>

    <section class="contact-hero">
        <div class="container">
            <div class="contact-hero-content" data-aos="fade-up">
                <span class="contact-badge">
                    <i class="fas fa-leaf"></i>
                    {{ __('Customer Care') }}
                </span>
                <h1 class="display-4">
                    {{ __($globalSettings['contact_heading'] ?? 'Get In Touch') }}
                </h1>
                <p class="lead mb-0">
                    {{ __($globalSettings['contact_subheading'] ?? "We'd love to hear from you. Our team is always here to help.") }}
                </p>
            </div>
        </div>
    </section>

    <section class="contact-stat-strip">
        <div class="container">
            <div class="contact-stat-panel" data-aos="fade-up">
                <div class="contact-stat">
                    <i class="fas fa-clock"></i>
                    <div>
                        <strong>{{ __('Quick Response') }}</strong>
                        <span>{{ __('Most messages are answered within business hours.') }}</span>
                    </div>
                </div>
                <div class="contact-stat">
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <strong>{{ __('Private Support') }}</strong>
                        <span>{{ __('Your details stay protected with our team.') }}</span>
                    </div>
                </div>
                <div class="contact-stat">
                    <i class="fas fa-headset"></i>
                    <div>
                        <strong>{{ __('Product Guidance') }}</strong>
                        <span>{{ __('Ask before choosing your herbal care.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-shell">
        <div class="container">
            <div class="row gx-lg-5 gy-5 align-items-start">
                <div class="col-lg-5">
                    <div class="contact-info-panel" data-aos="fade-right">
                        <span class="contact-section-label">
                            <a href="#contact-form" aria-label="{{ __('Jump to contact form') }}">
                                <i class="fas fa-address-card"></i>
                            </a>
                            {{ __('Contact Information') }}
                        </span>
                        <h2 class="contact-title h1 mb-3">{{ __('Reach Our Team') }}</h2>
                        <p class="contact-copy mb-4">
                            {{ __($globalSettings['contact_description'] ?? 'Have a question or comment? Use the form to send us a message or contact us directly using the details below.') }}
                        </p>

                        <div class="contact-method">
                            <span class="contact-method-icon">
                                <a href="{{ $mapUrl }}" target="_blank" rel="noopener" aria-label="{{ __('Open map') }}">
                                    <i class="fas fa-map-marker-alt"></i>
                                </a>
                            </span>
                            <div>
                                <h5 class="fw-bold">{{ __('Our Location') }}</h5>
                                <p class="mb-0"><a href="{{ $mapUrl }}" target="_blank" rel="noopener">{{ $contactAddress }}</a></p>
                            </div>
                        </div>

                        <div class="contact-method">
                            <span class="contact-method-icon">
                                <a href="tel:{{ preg_replace('/\s+/', '', $contactPhone) }}" aria-label="{{ __('Call us') }}">
                                    <i class="fas fa-phone"></i>
                                </a>
                            </span>
                            <div>
                                <h5 class="fw-bold">{{ __('Phone Number') }}</h5>
                                <p class="mb-0"><a href="tel:{{ preg_replace('/\s+/', '', $contactPhone) }}">{{ $contactPhone }}</a></p>
                                <div class="contact-copy-actions">
                                    <button type="button" class="contact-mini-action" data-copy="{{ e(preg_replace('/\s+/', ' ', $contactPhone)) }}">
                                        <i class="fas fa-copy"></i>{{ __('Copy') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="contact-method">
                            <span class="contact-method-icon">
                                <a href="mailto:{{ $contactEmail }}" aria-label="{{ __('Email us') }}">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </span>
                            <div>
                                <h5 class="fw-bold">{{ __('Email Address') }}</h5>
                                <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                                <div class="contact-copy-actions">
                                    <button type="button" class="contact-mini-action" data-copy="{{ e($contactEmail) }}">
                                        <i class="fas fa-copy"></i>{{ __('Copy') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="contact-map-card">
                            <h5 class="playfair fw-bold mb-2 text-white">{{ __('Visit or Locate Us') }}</h5>
                            <p class="mb-3">{{ __('Open our location in Maps for directions and nearby route options.') }}</p>
                            <a href="{{ $mapUrl }}" target="_blank" rel="noopener" class="contact-map-link">
                                {{ __('Open in Maps') }} <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="contact-form-card" data-aos="fade-left">
                        <span class="contact-section-label">
                            <i class="fas fa-paper-plane"></i>
                            {{ __('Message Us') }}
                        </span>
                        <h2 class="contact-title h1 mb-3">{{ __('Send Us a Message') }}</h2>
                        <p class="contact-copy mb-4">{{ __('Tell us what you need and we will guide you with the right next step.') }}</p>

                        @if(session('success'))
                            <div class="alert alert-success contact-alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger contact-alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ __('Please check the highlighted fields and try again.') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" id="contact-form">
                            @csrf
                            <div class="contact-preferences" aria-label="{{ __('Choose message type') }}">
                                <button type="button" class="contact-preference" data-subject="{{ __('Product Guidance') }}">
                                    <i class="fas fa-leaf me-1"></i>{{ __('Product Help') }}
                                </button>
                                <button type="button" class="contact-preference" data-subject="{{ __('Order Support') }}">
                                    <i class="fas fa-box me-1"></i>{{ __('Order') }}
                                </button>
                                <button type="button" class="contact-preference" data-subject="{{ __('Delivery Question') }}">
                                    <i class="fas fa-truck-fast me-1"></i>{{ __('Delivery') }}
                                </button>
                                <button type="button" class="contact-preference" data-subject="{{ __('General Question') }}">
                                    <i class="fas fa-comments me-1"></i>{{ __('General') }}
                                </button>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6 contact-field">
                                    <label class="form-label">{{ __('Your Name') }}</label>
                                    <input type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        class="form-control contact-control @error('name') is-invalid @enderror"
                                        autocomplete="name"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 contact-field">
                                    <label class="form-label">{{ __('Your Email') }}</label>
                                    <input type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="form-control contact-control @error('email') is-invalid @enderror"
                                        autocomplete="email"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 contact-field">
                                    <label class="form-label">{{ __('Phone') }}</label>
                                    <input type="text"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        class="form-control contact-control @error('phone') is-invalid @enderror"
                                        autocomplete="tel">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 contact-field">
                                    <label class="form-label">{{ __('Subject') }}</label>
                                    <input type="text"
                                        name="subject"
                                        id="contact-subject"
                                        value="{{ old('subject') }}"
                                        class="form-control contact-control @error('subject') is-invalid @enderror"
                                        required>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 contact-field">
                                    <label class="form-label">{{ __('Message') }}</label>
                                    <textarea name="message"
                                        rows="5"
                                        maxlength="900"
                                        id="contact-message"
                                        class="form-control contact-control @error('message') is-invalid @enderror"
                                        required>{{ old('message') }}</textarea>
                                    <div class="contact-form-tools">
                                        <span class="contact-response-note">
                                            <i class="fas fa-lock"></i>{{ __('Your message stays private.') }}
                                        </span>
                                        <span class="contact-counter" id="contact-counter">0 / 900</span>
                                    </div>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn contact-submit w-100" id="contact-submit">
                                        {{ __('Send Message') }} <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="contact-promises">
                <div class="contact-promise" data-aos="fade-up">
                    <i class="fas fa-comments"></i>
                    <h5 class="playfair fw-bold">{{ __('Clear Answers') }}</h5>
                    <p class="mb-0">{{ __('We keep replies direct, useful, and easy to act on.') }}</p>
                </div>
                <div class="contact-promise" data-aos="fade-up" data-aos-delay="100">
                    <i class="fas fa-leaf"></i>
                    <h5 class="playfair fw-bold">{{ __('Herbal Guidance') }}</h5>
                    <p class="mb-0">{{ __('Ask about products, categories, availability, or daily care choices.') }}</p>
                </div>
                <div class="contact-promise" data-aos="fade-up" data-aos-delay="200">
                    <i class="fas fa-truck-fast"></i>
                    <h5 class="playfair fw-bold">{{ __('Order Help') }}</h5>
                    <p class="mb-0">{{ __('Need help with delivery or checkout? Send your question here.') }}</p>
                </div>
            </div>

            <div class="contact-advanced-section">
                <div class="contact-process-card" data-aos="fade-up">
                    <span class="contact-section-label">
                        <i class="fas fa-map-signs"></i>{{ __('How It Works') }}
                    </span>
                    <h3 class="contact-title mb-4">{{ __('What Happens After You Send?') }}</h3>
                    <div class="contact-process-step">
                        <span>1</span>
                        <div>
                            <strong>{{ __('We review your message') }}</strong>
                            <small>{{ __('Your request is checked and routed to the right team member.') }}</small>
                        </div>
                    </div>
                    <div class="contact-process-step">
                        <span>2</span>
                        <div>
                            <strong>{{ __('We prepare a useful reply') }}</strong>
                            <small>{{ __('For product questions, we focus on practical guidance and next steps.') }}</small>
                        </div>
                    </div>
                    <div class="contact-process-step">
                        <span>3</span>
                        <div>
                            <strong>{{ __('You get clear support') }}</strong>
                            <small>{{ __('We help you continue with shopping, delivery, or product selection.') }}</small>
                        </div>
                    </div>
                </div>

                <div class="contact-faq-card" data-aos="fade-up" data-aos-delay="120">
                    <span class="contact-section-label">
                        <i class="fas fa-question-circle"></i>{{ __('Quick Questions') }}
                    </span>
                    <h3 class="contact-title mb-4">{{ __('Before You Message Us') }}</h3>

                    <div class="contact-faq-item is-open">
                        <button type="button" class="contact-faq-toggle">
                            {{ __('Can I ask about product suitability?') }}
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="contact-faq-body">
                            {{ __('Yes. Share what you are looking for and our team can point you toward suitable categories or products.') }}
                        </div>
                    </div>

                    <div class="contact-faq-item">
                        <button type="button" class="contact-faq-toggle">
                            {{ __('Can I contact you about an order?') }}
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="contact-faq-body">
                            {{ __('Yes. Include your order details in the message so we can understand the request faster.') }}
                        </div>
                    </div>

                    <div class="contact-faq-item">
                        <button type="button" class="contact-faq-toggle">
                            {{ __('What should I include in my message?') }}
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="contact-faq-body">
                            {{ __('Add your question, preferred contact detail, and any product or order information that helps us reply clearly.') }}
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
    const form = document.getElementById('contact-form');
    const submit = document.getElementById('contact-submit');
    const subject = document.getElementById('contact-subject');
    const message = document.getElementById('contact-message');
    const counter = document.getElementById('contact-counter');
    const floatingActions = document.getElementById('contact-floating-actions');
    const toast = document.getElementById('contact-toast');
    let toastTimer;

    function showToast(text) {
        if (!toast) return;

        toast.textContent = text;
        toast.classList.add('is-visible');
        window.clearTimeout(toastTimer);
        toastTimer = window.setTimeout(function () {
            toast.classList.remove('is-visible');
        }, 2200);
    }

    function updateCounter() {
        if (!message || !counter) return;

        const max = Number(message.getAttribute('maxlength') || 900);
        const length = message.value.length;
        counter.textContent = length + ' / ' + max;
        counter.classList.toggle('is-warning', length > max * 0.75 && length <= max * 0.9);
        counter.classList.toggle('is-danger', length > max * 0.9);
    }

    function updateFloatingActions() {
        if (!floatingActions) return;
        floatingActions.classList.toggle('is-visible', window.scrollY > 420);
    }

    document.querySelectorAll('.contact-preference').forEach(function (button) {
        button.addEventListener('click', function () {
            document.querySelectorAll('.contact-preference').forEach(function (item) {
                item.classList.remove('is-active');
            });

            button.classList.add('is-active');

            if (subject && button.dataset.subject) {
                subject.value = button.dataset.subject;
                subject.focus();
            }
        });
    });

    document.querySelectorAll('[data-copy]').forEach(function (button) {
        button.addEventListener('click', async function () {
            const value = button.dataset.copy || '';

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(value);
                } else {
                    const temp = document.createElement('textarea');
                    temp.value = value;
                    temp.setAttribute('readonly', '');
                    temp.style.position = 'fixed';
                    temp.style.opacity = '0';
                    document.body.appendChild(temp);
                    temp.select();
                    document.execCommand('copy');
                    document.body.removeChild(temp);
                }

                showToast('{{ __('Copied to clipboard') }}');
            } catch (error) {
                showToast('{{ __('Copy failed. Please copy manually.') }}');
            }
        });
    });

    document.querySelectorAll('.contact-faq-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            const item = button.closest('.contact-faq-item');
            if (!item) return;

            item.classList.toggle('is-open');
        });
    });

    if (message) {
        updateCounter();
        message.addEventListener('input', updateCounter);
    }

    updateFloatingActions();
    window.addEventListener('scroll', updateFloatingActions, { passive: true });

    if (form && submit) {
        form.addEventListener('submit', function () {
            submit.disabled = true;
            submit.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>{{ __('Sending...') }}';
        });
    }
});
</script>
@endpush
