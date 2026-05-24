@extends('layouts.app')

@push('styles')
<style>
:root {
    --account-green: #17382b;
    --account-green-light: #2d6a4f;
    --account-gold: #c8a165;
    --account-gold-light: #e2c08d;
    --account-ink: #1f2d26;
    --account-muted: #6f7d73;
    --account-line: rgba(26, 60, 46, 0.12);
    --account-soft: #f8f5f0;
    --account-shadow: 0 18px 44px rgba(26, 60, 46, 0.1);
}

.account-page {
    overflow: hidden;
    background:
        radial-gradient(circle at 8% 12%, rgba(45,106,79,0.08), transparent 28%),
        linear-gradient(180deg, #fff 0%, var(--account-soft) 100%);
}

.account-hero {
    position: relative;
    min-height: 360px;
    display: flex;
    align-items: center;
    margin-top: 50px;
    color: #fff;
    background:
        linear-gradient(105deg, rgba(12,24,18,0.95) 0%, rgba(23,56,43,0.82) 58%, rgba(45,106,79,0.58) 100%),
        url('https://images.unsplash.com/photo-1604881991720-f91add269bed?q=80&w=1920&auto=format&fit=crop');
    background-size: cover;
    background-position: center;
}

.account-hero::after {
    content: '';
    position: absolute;
    inset: auto 0 0;
    height: 88px;
    background: linear-gradient(180deg, transparent, rgba(248,245,240,0.98));
}

.account-hero-content {
    position: relative;
    z-index: 2;
    padding: 92px 0 118px;
}

.account-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: 1px solid rgba(226,192,141,0.42);
    border-radius: 50px;
    background: rgba(200,161,101,0.14);
    color: var(--account-gold-light);
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 2.2px;
    text-transform: uppercase;
    margin-bottom: 18px;
}

.account-hero h1,
.account-title {
    font-family: 'Playfair Display', serif;
    font-weight: 800;
    letter-spacing: 0;
}

.account-title {
    position: relative;
    display: block;
    width: fit-content;
    color: var(--account-green);
    text-shadow: 0 8px 24px rgba(26,60,46,0.08);
}

.account-title::after {
    content: '';
    position: absolute;
    left: 0;
    right: 24%;
    bottom: -8px;
    height: 4px;
    border-radius: 50px;
    background: linear-gradient(90deg, var(--account-gold), rgba(45,106,79,0));
}

.account-hero p {
    max-width: 680px;
    color: rgba(255,255,255,0.84);
    line-height: 1.8;
}

.account-shell {
    position: relative;
    z-index: 5;
    margin-top: -58px;
    padding-bottom: 76px;
}

.account-panel,
.account-sidebar,
.account-stat-card,
.account-orders-card,
.account-settings-card,
.account-empty,
.account-help-card,
.account-security-card {
    border: 1px solid var(--account-line);
    border-radius: 8px;
    background: #fff;
    box-shadow: var(--account-shadow);
}

.account-sidebar {
    position: sticky;
    top: 100px;
    overflow: hidden;
}

.account-sidebar::before {
    content: '';
    position: absolute;
    inset: 0 0 auto;
    height: 96px;
    background: linear-gradient(135deg, var(--account-green), var(--account-green-light));
}

.account-avatar {
    position: relative;
    z-index: 2;
    width: 86px;
    height: 86px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    border: 4px solid #fff;
    border-radius: 50%;
    color: var(--account-green);
    background: linear-gradient(135deg, var(--account-gold), var(--account-gold-light));
    font-size: 1.75rem;
    font-weight: 900;
    box-shadow: 0 14px 30px rgba(26,60,46,0.18);
}

.account-profile {
    position: relative;
    z-index: 2;
    padding: 58px 24px 24px;
    text-align: center;
}

.account-profile h5 {
    color: var(--account-ink);
}

.account-profile-email {
    color: var(--account-muted);
    overflow-wrap: anywhere;
}

.account-completion {
    margin: 18px 18px 20px;
    padding: 16px;
    border: 1px solid rgba(200,161,101,0.24);
    border-radius: 8px;
    background: linear-gradient(180deg, rgba(248,245,240,0.94), #fff);
}

.account-completion-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 10px;
}

.account-completion-head span {
    color: var(--account-green);
    font-size: 0.78rem;
    font-weight: 900;
}

.account-completion-head strong {
    color: var(--account-gold);
    font-size: 0.86rem;
}

.account-completion-bar {
    height: 8px;
    overflow: hidden;
    border-radius: 50px;
    background: rgba(26,60,46,0.08);
}

.account-completion-bar span {
    display: block;
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, var(--account-gold), var(--account-green-light));
}

.account-completion p {
    color: var(--account-muted);
    font-size: 0.76rem;
    line-height: 1.55;
    margin: 10px 0 0;
}

.account-nav {
    padding: 0 18px 22px;
}

.account-nav .nav-link,
.account-logout {
    min-height: 48px;
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid transparent;
    border-radius: 8px !important;
    color: var(--account-ink);
    font-weight: 800;
    transition: transform 0.22s ease, border-color 0.22s ease, background 0.22s ease, color 0.22s ease, box-shadow 0.22s ease;
}

.account-nav .nav-link i,
.account-logout i {
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 auto;
    border-radius: 50%;
    color: var(--account-green);
    background: rgba(200,161,101,0.16);
}

.account-nav .nav-link.active {
    color: #fff !important;
    border-color: rgba(200,161,101,0.38);
    background: linear-gradient(135deg, var(--account-green), var(--account-green-light)) !important;
    box-shadow: 0 12px 28px rgba(26,60,46,0.18);
}

.account-nav .nav-link.active i {
    color: var(--account-green);
    background: var(--account-gold-light);
}

.account-nav .nav-link:not(.active):hover,
.account-logout:hover {
    transform: translateX(4px);
    color: var(--account-green);
    border-color: rgba(200,161,101,0.3);
    background: rgba(200,161,101,0.1);
}

.account-logout {
    text-decoration: none;
}

.account-logout,
.account-logout i {
    color: #c84242;
}

.account-content {
    min-height: 640px;
}

.account-section-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 18px;
    margin-bottom: 24px;
}

.account-section-label {
    display: flex;
    width: fit-content;
    align-items: center;
    gap: 8px;
    border: 1px solid rgba(200,161,101,0.26);
    border-radius: 50px;
    color: var(--account-green);
    background: rgba(200,161,101,0.12);
    padding: 7px 14px;
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 1.8px;
    text-transform: uppercase;
    margin-bottom: 12px;
}

.account-copy {
    color: var(--account-muted);
    line-height: 1.8;
}

.account-mini-cta {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    border-radius: 50px;
    color: var(--account-green);
    background: #fff;
    border: 1px solid rgba(26,60,46,0.12);
    padding: 11px 16px;
    font-size: 0.82rem;
    font-weight: 900;
    text-decoration: none;
    white-space: nowrap;
    box-shadow: 0 10px 24px rgba(26,60,46,0.08);
    transition: transform 0.22s ease, background 0.22s ease, color 0.22s ease;
}

.account-mini-cta:hover {
    transform: translateY(-3px);
    color: #fff;
    background: var(--account-green);
}

.account-stat-card {
    position: relative;
    overflow: hidden;
    height: 100%;
    padding: 24px;
    transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
}

.account-stat-card::after {
    content: '';
    position: absolute;
    inset: auto 18px 0;
    height: 4px;
    border-radius: 8px 8px 0 0;
    background: linear-gradient(90deg, var(--account-gold), var(--account-green-light));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.28s ease;
}

.account-stat-card:hover {
    transform: translateY(-8px);
    border-color: rgba(200,161,101,0.42);
    box-shadow: 0 24px 52px rgba(26,60,46,0.14);
}

.account-stat-card:hover::after {
    transform: scaleX(1);
}

.account-stat-icon {
    width: 54px;
    height: 54px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: var(--account-green);
    background: rgba(200,161,101,0.18);
    font-size: 1.25rem;
    margin-bottom: 16px;
    transition: transform 0.28s ease, color 0.28s ease, background 0.28s ease;
}

.account-stat-card:hover .account-stat-icon {
    transform: rotate(-8deg) scale(1.08);
    color: #fff;
    background: var(--account-green);
}

.account-stat-card:hover .account-stat-icon .fa-heart,
.account-stat-card:hover .account-stat-icon .far.fa-heart {
    color: #e75d5d;
    text-shadow: 0 0 0 #fff, 0 8px 18px rgba(231,93,93,0.2);
}

.account-stat-card h2 {
    color: var(--account-ink);
    font-weight: 900;
}

.account-stat-card p {
    color: var(--account-muted);
}

.account-help-card,
.account-security-card {
    overflow: hidden;
    padding: 24px;
}

.account-security-card h4 {
    color: var(--account-green);
    position: relative;
    display: block;
    width: fit-content;
    padding-bottom: 8px;
}

.account-security-card h4::after {
    content: '';
    position: absolute;
    left: 0;
    right: 18%;
    bottom: 0;
    height: 3px;
    border-radius: 50px;
    background: linear-gradient(90deg, var(--account-gold), rgba(45,106,79,0));
}

.account-help-card {
    background:
        linear-gradient(135deg, rgba(23,56,43,0.97), rgba(45,106,79,0.92)),
        linear-gradient(90deg, rgba(200,161,101,0.2), transparent);
    color: #fff;
}

.account-help-card p {
    color: rgba(255,255,255,0.78);
}

.account-action-list {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-top: 18px;
}

.account-action-chip {
    min-height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border-radius: 8px;
    color: var(--account-green);
    background: rgba(200,161,101,0.16);
    border: 1px solid rgba(200,161,101,0.24);
    font-weight: 900;
    text-decoration: none;
    transition: transform 0.22s ease, background 0.22s ease, color 0.22s ease;
}

.account-action-chip:hover {
    transform: translateY(-3px);
    color: var(--account-green);
    background: var(--account-gold-light);
}

.account-orders-card,
.account-settings-card {
    overflow: hidden;
}

.account-table {
    margin-bottom: 0;
}

.account-table thead {
    color: var(--account-green);
    background: rgba(248,245,240,0.92);
}

.account-table th {
    border: 0;
    padding: 16px 18px;
    font-size: 0.72rem;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.account-table td {
    border-color: rgba(26,60,46,0.08);
    padding: 16px 18px;
}

.account-table tbody tr {
    transition: background 0.2s ease, transform 0.2s ease;
}

.account-table tbody tr:hover {
    background: rgba(200,161,101,0.08);
}

.account-order-number {
    color: var(--account-ink);
    font-weight: 900;
}

.account-status-badge {
    border-radius: 50px;
    padding: 8px 12px;
    font-size: 0.7rem;
    font-weight: 900;
    letter-spacing: 0.7px;
    text-transform: uppercase;
}

.account-remarks-btn {
    border-radius: 50px;
    font-size: 0.78rem;
    font-weight: 800;
}

.account-empty {
    padding: 54px 28px;
    text-align: center;
    background:
        radial-gradient(circle at 50% 0%, rgba(200,161,101,0.16), transparent 34%),
        #fff;
}

.account-empty-icon {
    width: 78px;
    height: 78px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
    border-radius: 50%;
    color: var(--account-green);
    background: rgba(200,161,101,0.18);
    font-size: 2rem;
}

.account-form-grid {
    padding: clamp(22px, 4vw, 36px);
}

.account-field label {
    color: var(--account-green);
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 1.1px;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.account-control {
    min-height: 52px;
    border: 1px solid rgba(26,60,46,0.12) !important;
    border-radius: 8px !important;
    background: #fff !important;
    color: var(--account-ink) !important;
    padding: 12px 16px !important;
    box-shadow: none !important;
    transition: border-color 0.22s ease, box-shadow 0.22s ease, transform 0.22s ease;
}

.account-control:focus {
    border-color: rgba(200,161,101,0.72) !important;
    box-shadow: 0 0 0 4px rgba(200,161,101,0.14) !important;
    transform: translateY(-1px);
}

.account-control[readonly] {
    color: var(--account-muted) !important;
    background: rgba(248,245,240,0.9) !important;
}

.account-password-toggle {
    min-width: 52px;
    border: 1px solid rgba(26,60,46,0.12) !important;
    border-left: 0 !important;
    border-radius: 0 8px 8px 0 !important;
    color: var(--account-green) !important;
    background: #fff !important;
}

.account-password-input {
    border-radius: 8px 0 0 8px !important;
}

.account-divider {
    border-color: rgba(26,60,46,0.1);
    margin: 28px 0;
}

.password-meter {
    height: 8px;
    overflow: hidden;
    border-radius: 50px;
    background: rgba(26,60,46,0.08);
}

.password-meter span {
    display: block;
    width: 0;
    height: 100%;
    border-radius: inherit;
    background: #c84242;
    transition: width 0.24s ease, background 0.24s ease;
}

.password-meter-text {
    color: var(--account-muted);
    font-size: 0.78rem;
    font-weight: 800;
}

.account-save-btn {
    min-height: 54px;
    border: 0;
    border-radius: 8px;
    color: #fff;
    background: linear-gradient(135deg, var(--account-green), var(--account-green-light));
    font-weight: 900;
    box-shadow: 0 16px 34px rgba(26,60,46,0.2);
    transition: transform 0.24s ease, box-shadow 0.24s ease;
}

.account-save-btn:hover,
.account-save-btn:focus {
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 24px 46px rgba(26,60,46,0.26);
}

.account-alert {
    border: 0;
    border-radius: 8px;
    box-shadow: 0 10px 24px rgba(26,60,46,0.08);
}

.account-fade {
    animation: accountFade 0.5s ease both;
}

@keyframes accountFade {
    from {
        opacity: 0;
        transform: translateY(14px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 991.98px) {
    .account-hero {
        margin-top: 0;
        min-height: auto;
    }

    .account-hero-content {
        padding: 108px 0 96px;
    }

    .account-shell {
        margin-top: 0;
        padding-top: 48px;
    }

    .account-sidebar {
        position: relative;
        top: auto;
    }

    .account-action-list {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 767.98px) {
    .account-hero h1 {
        font-size: 2.5rem;
    }

    .account-section-head {
        display: block;
    }

    .account-mini-cta {
        margin-top: 14px;
    }

    .account-table {
        min-width: 760px;
    }
}
</style>
@endpush

@section('content')
@php
    $initials = collect(explode(' ', $user->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('');
    $activeTab = (session('active_tab') == 'settings' || $errors->any()) ? 'settings' : 'dashboard';
    $profileFields = collect([
        $user->name,
        $user->email,
        $user->phone,
        $user->address,
    ]);
    $profileCompletePercent = round(($profileFields->filter()->count() / max($profileFields->count(), 1)) * 100);
@endphp

<main class="account-page">
    <section class="account-hero">
        <div class="container">
            <div class="account-hero-content account-fade">
                <span class="account-badge">
                    <i class="fas fa-user-shield"></i>
                    {{ __('Secure Account') }}
                </span>
                <h1 class="display-4 mb-3">{{ __('My Account') }}</h1>
                <p class="lead mb-0">
                    {{ __('Manage your orders, saved details, and account settings from one clean dashboard.') }}
                </p>
            </div>
        </div>
    </section>

    <section class="account-shell">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-3">
                    <aside class="account-sidebar account-fade">
                        <div class="account-profile">
                            <div class="account-avatar">
                                {{ strtoupper($initials) }}
                            </div>
                            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                            <p class="account-profile-email small mb-0">{{ $user->email }}</p>
                        </div>

                        <div class="account-completion">
                            <div class="account-completion-head">
                                <span>{{ __('Profile Strength') }}</span>
                                <strong>{{ $profileCompletePercent }}%</strong>
                            </div>
                            <div class="account-completion-bar" aria-hidden="true">
                                <span style="width: {{ $profileCompletePercent }}%;"></span>
                            </div>
                            <p>{{ __('Complete your phone and address details for smoother order support.') }}</p>
                        </div>

                        <div class="account-nav nav flex-column nav-pills text-start" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link {{ $activeTab == 'dashboard' ? 'active' : '' }} mb-2 px-3 py-2"
                                data-bs-toggle="pill"
                                data-bs-target="#dashboard"
                                type="button"
                                role="tab">
                                <i class="fas fa-home"></i> {{ __('Dashboard') }}
                            </button>
                            <button class="nav-link mb-2 px-3 py-2"
                                data-bs-toggle="pill"
                                data-bs-target="#orders"
                                type="button"
                                role="tab">
                                <i class="fas fa-box"></i> {{ __('My Orders') }}
                            </button>
                            <button class="nav-link {{ $activeTab == 'settings' ? 'active' : '' }} mb-2 px-3 py-2"
                                data-bs-toggle="pill"
                                data-bs-target="#settings"
                                type="button"
                                role="tab">
                                <i class="fas fa-cog"></i> {{ __('Settings') }}
                            </button>

                            <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-none">@csrf</form>
                            <a href="#"
                                class="account-logout px-3 py-2 mt-3"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                            </a>
                        </div>
                    </aside>
                </div>

                <div class="col-lg-9">
                    <div class="tab-content account-content" id="v-pills-tabContent">
                        <div class="tab-pane fade {{ $activeTab == 'dashboard' ? 'show active' : '' }} account-fade" id="dashboard" role="tabpanel">
                            <div class="account-section-head">
                                <div>
                                    <span class="account-section-label">
                                        <i class="fas fa-chart-line"></i>
                                        {{ __('Overview') }}
                                    </span>
                                    <h2 class="account-title h1 mb-2">{{ __('Dashboard') }}</h2>
                                    <p class="account-copy mb-0">
                                        {{ __('Hello') }} {{ $user->name }}! {{ __("From your account dashboard you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.") }}
                                    </p>
                                </div>
                                <a href="{{ route('shop.index') }}" class="account-mini-cta">
                                    {{ __('Continue Shopping') }} <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-4">
                                    <div class="account-stat-card">
                                        <span class="account-stat-icon"><i class="fas fa-box"></i></span>
                                        <h2 class="mb-1">{{ $ordersCount }}</h2>
                                        <p class="mb-0">{{ __('Total Orders') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="account-stat-card">
                                        <span class="account-stat-icon"><i class="far fa-heart"></i></span>
                                        <h2 class="mb-1">{{ $wishlistCount }}</h2>
                                        <p class="mb-0">{{ __('Wishlist Items') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="account-stat-card">
                                        <span class="account-stat-icon"><i class="fas fa-map-marker-alt"></i></span>
                                        <h2 class="mb-1">{{ $addressCount }}</h2>
                                        <p class="mb-0">{{ __('Saved Addresses') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-lg-7">
                                    <div class="account-help-card h-100">
                                        <span class="account-section-label" style="color: var(--account-gold-light); background: rgba(200,161,101,0.14);">
                                            <i class="fas fa-leaf"></i>
                                            {{ __('Quick Actions') }}
                                        </span>
                                        <h3 class="playfair fw-bold mb-2 text-white">{{ __('Everything Ready For Your Next Order') }}</h3>
                                        <p class="mb-0">{{ __('Jump straight to shopping, review your order history, or keep your account details fresh.') }}</p>
                                        <div class="account-action-list">
                                            <a href="{{ route('shop.index') }}" class="account-action-chip">
                                                <i class="fas fa-store"></i> {{ __('Shop') }}
                                            </a>
                                            <button class="account-action-chip border-0"
                                                type="button"
                                                data-bs-toggle="pill"
                                                data-bs-target="#orders">
                                                <i class="fas fa-receipt"></i> {{ __('Orders') }}
                                            </button>
                                            <button class="account-action-chip border-0"
                                                type="button"
                                                data-bs-toggle="pill"
                                                data-bs-target="#settings">
                                                <i class="fas fa-user-cog"></i> {{ __('Profile') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="account-security-card h-100">
                                        <span class="account-section-label">
                                            <i class="fas fa-shield-alt"></i>
                                            {{ __('Account Care') }}
                                        </span>
                                        <h4 class="playfair fw-bold mb-3">{{ __('Keep Details Updated') }}</h4>
                                        <p class="account-copy mb-3">{{ __('Accurate phone and address details help support faster order handling.') }}</p>
                                        <button class="account-mini-cta border-0"
                                            type="button"
                                            data-bs-toggle="pill"
                                            data-bs-target="#settings">
                                            {{ __('Update Settings') }} <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade account-fade" id="orders" role="tabpanel">
                            <div class="account-section-head">
                                <div>
                                    <span class="account-section-label">
                                        <i class="fas fa-receipt"></i>
                                        {{ __('History') }}
                                    </span>
                                    <h2 class="account-title h1 mb-2">{{ __('My Orders') }}</h2>
                                    <p class="account-copy mb-0">{{ __('Track totals, payment methods, and staff remarks for your previous orders.') }}</p>
                                </div>
                            </div>

                            @if($orders->count() > 0)
                                <div class="account-orders-card table-responsive">
                                    <table class="table align-middle text-center account-table">
                                        <thead>
                                            <tr>
                                                <th class="text-start">{{ __('Order ID') }}</th>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Total') }}</th>
                                                <th>{{ __('Payment') }}</th>
                                                <th>{{ __('Remarks') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td class="text-start">
                                                        <span class="account-order-number">#{{ $order->order_number }}</span>
                                                    </td>
                                                    <td class="text-muted small">
                                                        {{ $order->created_at->format('M d, Y') }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $badgeClass = [
                                                                'pending' => 'bg-warning text-dark',
                                                                'processing' => 'bg-info text-white',
                                                                'shipped' => 'bg-primary text-white',
                                                                'delivered' => 'bg-success text-white',
                                                                'cancelled' => 'bg-danger text-white'
                                                            ][$order->status] ?? 'bg-secondary text-white';
                                                        @endphp
                                                        <span class="badge account-status-badge {{ $badgeClass }}">
                                                            {{ $order->status }}
                                                        </span>
                                                    </td>
                                                    <td class="fw-bold text-primary-custom">
                                                        {{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($order->total, 2) }}
                                                    </td>
                                                    <td class="text-muted small text-uppercase">
                                                        {{ str_replace('_', ' ', $order->payment_method) }}
                                                    </td>
                                                    <td>
                                                        @if($order->admin_remarks)
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-secondary account-remarks-btn"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="{{ $order->admin_remarks }}">
                                                                <i class="fas fa-info-circle me-1"></i> {{ __('View') }}
                                                            </button>
                                                            <div class="d-none d-md-block text-muted small mt-1" style="max-width: 150px; font-style: italic;">
                                                                "{{ Str::limit($order->admin_remarks, 30) }}"
                                                            </div>
                                                        @else
                                                            <span class="text-muted small">{{ __('No remarks') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="account-empty">
                                    <span class="account-empty-icon">
                                        <i class="fas fa-box-open"></i>
                                    </span>
                                    <h4 class="playfair fw-bold">{{ __('No orders found') }}</h4>
                                    <p class="account-copy">{{ __('You haven\'t placed any orders yet.') }}</p>
                                    <a href="{{ route('shop.index') }}" class="account-mini-cta">
                                        {{ __('Go to Shop') }} <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade {{ $activeTab == 'settings' ? 'show active' : '' }} account-fade" id="settings" role="tabpanel">
                            <div class="account-section-head">
                                <div>
                                    <span class="account-section-label">
                                        <i class="fas fa-user-cog"></i>
                                        {{ __('Profile') }}
                                    </span>
                                    <h2 class="account-title h1 mb-2">{{ __('Account Settings') }}</h2>
                                    <p class="account-copy mb-0">{{ __('Update your profile details and password from the secure form below.') }}</p>
                                </div>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success account-alert">
                                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger account-alert">
                                    <i class="fas fa-exclamation-circle me-2"></i> {{ __('Please review the highlighted fields and try again.') }}
                                </div>
                            @endif

                            <div class="account-settings-card">
                                <form action="{{ route('account.update') }}" method="POST" id="account-settings-form">
                                    @csrf
                                    <div class="account-form-grid">
                                        <div class="row g-3">
                                            <div class="col-md-6 account-field">
                                                <label class="form-label">{{ __('Full Name') }}</label>
                                                <input type="text"
                                                    name="name"
                                                    class="form-control account-control @error('name') is-invalid @enderror"
                                                    value="{{ old('name', $user->name) }}"
                                                    autocomplete="name"
                                                    required>
                                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6 account-field">
                                                <label class="form-label">{{ __('Email (Cannot be changed)') }}</label>
                                                <input type="email"
                                                    class="form-control account-control text-muted"
                                                    value="{{ $user->email }}"
                                                    autocomplete="email"
                                                    readonly>
                                            </div>
                                            <div class="col-md-6 account-field">
                                                <label class="form-label">{{ __('Phone Number') }}</label>
                                                <input type="text"
                                                    name="phone"
                                                    class="form-control account-control @error('phone') is-invalid @enderror"
                                                    value="{{ old('phone', $user->phone) }}"
                                                    autocomplete="tel">
                                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6 account-field">
                                                <label class="form-label">{{ __('Address') }}</label>
                                                <input type="text"
                                                    name="address"
                                                    class="form-control account-control @error('address') is-invalid @enderror"
                                                    value="{{ old('address', $user->address) }}"
                                                    autocomplete="street-address">
                                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>

                                        <hr class="account-divider">

                                        <div class="mb-3">
                                            <span class="account-section-label">
                                                <i class="fas fa-lock"></i>
                                                {{ __('Password') }}
                                            </span>
                                            <h4 class="playfair fw-bold mb-1">{{ __('Change Password') }}</h4>
                                            <p class="account-copy small mb-0">{{ __('Leave blank if you don\'t want to change it.') }}</p>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-12 account-field">
                                                <label class="form-label">{{ __('Current Password') }}</label>
                                                <div class="input-group">
                                                    <input type="password"
                                                        name="current_password"
                                                        id="current_password"
                                                        class="form-control account-control account-password-input @error('current_password') is-invalid @enderror"
                                                        autocomplete="current-password">
                                                    <button class="btn account-password-toggle @error('current_password') border-danger @enderror"
                                                        type="button"
                                                        data-toggle-password="current_password"
                                                        aria-label="{{ __('Show password') }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 account-field">
                                                <label class="form-label">{{ __('New Password') }}</label>
                                                <div class="input-group">
                                                    <input type="password"
                                                        name="new_password"
                                                        id="new_password"
                                                        class="form-control account-control account-password-input @error('new_password') is-invalid @enderror"
                                                        autocomplete="new-password">
                                                    <button class="btn account-password-toggle @error('new_password') border-danger @enderror"
                                                        type="button"
                                                        data-toggle-password="new_password"
                                                        aria-label="{{ __('Show password') }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 account-field">
                                                <label class="form-label">{{ __('Confirm New Password') }}</label>
                                                <div class="input-group">
                                                    <input type="password"
                                                        name="new_password_confirmation"
                                                        id="new_password_confirmation"
                                                        class="form-control account-control account-password-input"
                                                        autocomplete="new-password">
                                                    <button class="btn account-password-toggle"
                                                        type="button"
                                                        data-toggle-password="new_password_confirmation"
                                                        aria-label="{{ __('Show password') }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                                    <span class="password-meter-text">{{ __('Password strength') }}</span>
                                                    <span class="password-meter-text" id="password-strength-label">{{ __('Not started') }}</span>
                                                </div>
                                                <div class="password-meter" aria-hidden="true">
                                                    <span id="password-strength-bar"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 text-end">
                                            <button type="submit" class="btn account-save-btn px-5" id="account-save-btn">
                                                {{ __('Save Changes') }} <i class="fas fa-arrow-right ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
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
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

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

    var passwordInput = document.getElementById('new_password');
    var strengthBar = document.getElementById('password-strength-bar');
    var strengthLabel = document.getElementById('password-strength-label');

    if (passwordInput && strengthBar && strengthLabel) {
        passwordInput.addEventListener('input', function () {
            var value = passwordInput.value;
            var score = 0;

            if (value.length >= 8) score++;
            if (/[A-Z]/.test(value)) score++;
            if (/[0-9]/.test(value)) score++;
            if (/[^A-Za-z0-9]/.test(value)) score++;

            var widths = ['0%', '28%', '52%', '76%', '100%'];
            var colors = ['#c84242', '#c84242', '#d6a33d', '#2d6a4f', '#17382b'];
            var labels = [
                '{{ __('Not started') }}',
                '{{ __('Weak') }}',
                '{{ __('Fair') }}',
                '{{ __('Good') }}',
                '{{ __('Strong') }}'
            ];

            strengthBar.style.width = widths[score];
            strengthBar.style.background = colors[score];
            strengthLabel.textContent = labels[score];
        });
    }

    var form = document.getElementById('account-settings-form');
    var saveButton = document.getElementById('account-save-btn');

    if (form && saveButton) {
        form.addEventListener('submit', function () {
            saveButton.disabled = true;
            saveButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>{{ __('Saving...') }}';
        });
    }
});
</script>
@endpush
