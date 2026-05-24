@extends('layouts.app')

@push('styles')
<style>
:root {
    --cart-green: #17382b;
    --cart-green-light: #2d6a4f;
    --cart-gold: #c8a165;
    --cart-gold-light: #e2c08d;
    --cart-ink: #1f2d26;
    --cart-muted: #6f7d73;
    --cart-line: rgba(26, 60, 46, 0.12);
    --cart-soft: #f8f5f0;
    --cart-shadow: 0 22px 54px rgba(26, 60, 46, 0.13);
}

.cart-page {
    min-height: 100vh;
    overflow: hidden;
    background:
        radial-gradient(circle at 8% 12%, rgba(45, 106, 79, 0.1), transparent 28%),
        radial-gradient(circle at 92% 18%, rgba(200, 161, 101, 0.13), transparent 24%),
        linear-gradient(180deg, #fff 0%, var(--cart-soft) 100%);
}

.cart-hero {
    position: relative;
    min-height: 340px;
    display: flex;
    align-items: center;
    margin-top: 50px;
    color: #fff;
    background:
        linear-gradient(105deg, rgba(12, 24, 18, 0.95) 0%, rgba(23, 56, 43, 0.84) 58%, rgba(45, 106, 79, 0.58) 100%),
        url('https://images.unsplash.com/photo-1471864190281-a93a3070b6de?q=80&w=1920&auto=format&fit=crop');
    background-size: cover;
    background-position: center;
}

.cart-hero::after {
    content: '';
    position: absolute;
    inset: auto 0 0;
    height: 94px;
    background: linear-gradient(180deg, transparent, rgba(248, 245, 240, 0.98));
}

.cart-hero-content {
    position: relative;
    z-index: 2;
    max-width: 760px;
    padding: 92px 0 118px;
}

.cart-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: 1px solid rgba(226, 192, 141, 0.42);
    border-radius: 50px;
    background: rgba(200, 161, 101, 0.14);
    color: var(--cart-gold-light);
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 2.2px;
    text-transform: uppercase;
    margin-bottom: 18px;
}

.cart-hero h1,
.cart-title {
    font-family: 'Playfair Display', serif;
    font-weight: 800;
    letter-spacing: 0;
}

.cart-hero p {
    max-width: 650px;
    color: rgba(255, 255, 255, 0.84);
    line-height: 1.8;
}

.cart-shell {
    position: relative;
    z-index: 5;
    margin-top: -72px;
    padding-bottom: 82px;
}

.cart-progress {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
    border: 1px solid var(--cart-line);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.94);
    box-shadow: var(--cart-shadow);
    padding: 16px;
    margin-bottom: 28px;
}

.cart-step {
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--cart-muted);
    border-radius: 8px;
    padding: 12px;
}

.cart-step.active {
    color: var(--cart-green);
    background: rgba(200, 161, 101, 0.11);
}

.cart-step-icon {
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 42px;
    border-radius: 50%;
    color: #fff;
    background: linear-gradient(135deg, var(--cart-green), var(--cart-green-light));
}

.cart-panel,
.cart-summary,
.cart-empty-card {
    border: 1px solid var(--cart-line);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.94);
    box-shadow: 0 16px 36px rgba(26, 60, 46, 0.09);
}

.cart-panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    border-bottom: 1px solid var(--cart-line);
    padding: 20px 22px;
}

.cart-title {
    position: relative;
    display: inline-block;
    color: #123524;
    background: linear-gradient(135deg, #0f3d2e 0%, #2f7d4f 48%, #c7962e 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    padding-bottom: 12px;
    margin-bottom: 0;
    text-shadow: 0 12px 28px rgba(27, 67, 50, 0.12);
}

.cart-title::after {
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

.cart-table {
    margin-bottom: 0;
}

.cart-table thead th {
    border-bottom: 1px solid var(--cart-line);
    color: var(--cart-muted);
    background: rgba(248, 245, 240, 0.72);
    font-size: 0.75rem;
    font-weight: 900;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.cart-table tbody tr {
    transition: background 0.22s ease;
}

.cart-table tbody tr:hover {
    background: rgba(200, 161, 101, 0.06);
}

.cart-product-img {
    width: 86px;
    height: 86px;
    border-radius: 8px;
    object-fit: cover;
    box-shadow: 0 12px 24px rgba(26, 60, 46, 0.12);
}

.cart-product-link {
    color: var(--cart-ink);
    text-decoration: none;
    transition: color 0.22s ease;
}

.cart-product-link:hover {
    color: var(--cart-green-light);
}

.cart-category-pill,
.cart-stock-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border-radius: 50px;
    color: var(--cart-green);
    background: rgba(45, 106, 79, 0.08);
    padding: 5px 9px;
    font-size: 0.72rem;
    font-weight: 800;
}

.cart-qty {
    width: 124px;
    border: 1px solid rgba(26, 60, 46, 0.12);
    border-radius: 50px;
    overflow: hidden;
    background: #fff;
}

.cart-qty .btn {
    width: 38px;
    border: 0;
    color: var(--cart-green);
    background: transparent;
    font-weight: 900;
}

.cart-qty .btn:hover {
    background: rgba(200, 161, 101, 0.12);
}

.cart-qty .form-control {
    border: 0;
    color: var(--cart-ink);
    font-weight: 900;
    box-shadow: none;
}

.remove-cart-btn {
    width: 40px;
    height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #c0392b;
    background: rgba(192, 57, 43, 0.08);
}

.remove-cart-btn:hover {
    color: #fff;
    background: #c0392b;
}

.cart-mobile-card {
    border: 1px solid var(--cart-line);
    border-radius: 8px;
    background: #fff;
    box-shadow: 0 14px 30px rgba(26, 60, 46, 0.08);
}

[data-cart-id] {
    position: relative;
}

[data-cart-id].is-updating {
    opacity: 0.72;
    pointer-events: none;
}

[data-cart-id].is-updating::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background: linear-gradient(90deg, transparent, rgba(200, 161, 101, 0.18), transparent);
    animation: cartRowShimmer 0.9s ease infinite;
}

.cart-summary {
    position: sticky;
    top: 96px;
    overflow: hidden;
}

.cart-summary::before {
    content: '';
    display: block;
    height: 5px;
    background: linear-gradient(90deg, var(--cart-gold), var(--cart-green-light));
}

.cart-summary-row {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    color: var(--cart-muted);
    margin-bottom: 14px;
}

.cart-summary-row strong,
.cart-summary-row span:last-child {
    color: var(--cart-ink);
    font-weight: 900;
}

.cart-total-row {
    border-top: 1px solid var(--cart-line);
    margin-top: 18px;
    padding-top: 20px;
}

.cart-total-row h3 {
    color: var(--cart-green);
}

.cart-summary-title,
.cart-total-label {
    color: #123524;
    background: linear-gradient(135deg, #0f3d2e 0%, #2f7d4f 48%, #c7962e 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 10px 24px rgba(27, 67, 50, 0.12);
}

.cart-total-label {
    font-weight: 900;
}

.coupon-box {
    border: 1px solid rgba(200, 161, 101, 0.24);
    border-radius: 8px;
    background: rgba(200, 161, 101, 0.09);
    padding: 14px;
}

.coupon-input {
    min-height: 48px;
    border: 1px solid rgba(26, 60, 46, 0.12) !important;
    border-radius: 8px 0 0 8px !important;
    box-shadow: none !important;
}

.coupon-btn {
    border: 0;
    border-radius: 0 8px 8px 0 !important;
    color: #fff;
    background: linear-gradient(135deg, var(--cart-green), var(--cart-green-light));
    font-weight: 900;
}

.cart-checkout-btn,
.cart-shop-btn {
    min-height: 54px;
    border: 0;
    border-radius: 8px;
    font-weight: 900;
    transition: transform 0.24s ease, box-shadow 0.24s ease;
}

.cart-checkout-btn {
    color: #fff;
    background: linear-gradient(135deg, var(--cart-green), var(--cart-green-light));
    box-shadow: 0 16px 34px rgba(26, 60, 46, 0.22);
}

.cart-checkout-btn:hover,
.cart-shop-btn:hover {
    transform: translateY(-2px);
}

.cart-shop-btn {
    border: 1px solid rgba(26, 60, 46, 0.18);
    color: var(--cart-green);
    background: #fff;
}

.cart-trust-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 9px;
    margin-top: 18px;
}

.cart-trust-chip {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    border: 1px solid rgba(200, 161, 101, 0.24);
    border-radius: 8px;
    color: var(--cart-green);
    background: rgba(200, 161, 101, 0.11);
    min-height: 38px;
    font-size: 0.72rem;
    font-weight: 900;
}

.cart-protection-note {
    display: flex;
    gap: 11px;
    align-items: flex-start;
    border: 1px solid rgba(200, 161, 101, 0.24);
    border-radius: 8px;
    color: var(--cart-muted);
    background: rgba(200, 161, 101, 0.09);
    padding: 13px 14px;
    margin-top: 16px;
    font-size: 0.82rem;
    line-height: 1.55;
}

.cart-protection-note i {
    color: var(--cart-gold);
    margin-top: 3px;
}

.cart-modal-backdrop {
    position: fixed;
    inset: 0;
    z-index: 1090;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(12, 24, 18, 0.58);
    backdrop-filter: blur(8px);
    opacity: 0;
    pointer-events: none;
    padding: 18px;
    transition: opacity 0.22s ease;
}

.cart-modal-backdrop.show {
    opacity: 1;
    pointer-events: auto;
}

.cart-remove-modal {
    width: min(430px, 100%);
    border: 1px solid rgba(200, 161, 101, 0.28);
    border-radius: 8px;
    background: #fff;
    box-shadow: 0 30px 80px rgba(12, 24, 18, 0.32);
    overflow: hidden;
    transform: translateY(14px) scale(0.98);
    transition: transform 0.22s ease;
}

.cart-modal-backdrop.show .cart-remove-modal {
    transform: translateY(0) scale(1);
}

.cart-remove-modal-header {
    padding: 22px;
    color: #fff;
    background: linear-gradient(135deg, var(--cart-green), var(--cart-green-light));
}

.cart-remove-modal-icon {
    width: 54px;
    height: 54px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: var(--cart-green);
    background: linear-gradient(135deg, var(--cart-gold), var(--cart-gold-light));
    margin-bottom: 12px;
}

.cart-remove-modal-body {
    padding: 22px;
}

.cart-modal-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.cart-modal-cancel,
.cart-modal-confirm {
    min-height: 48px;
    border-radius: 8px;
    font-weight: 900;
}

.cart-modal-cancel {
    border: 1px solid rgba(26, 60, 46, 0.16);
    color: var(--cart-green);
    background: #fff;
}

.cart-modal-confirm {
    border: 0;
    color: #fff;
    background: linear-gradient(135deg, #b9342a, #df5a4f);
}

@keyframes cartRowShimmer {
    from { transform: translateX(-100%); }
    to { transform: translateX(100%); }
}

.cart-toast {
    position: fixed;
    right: 18px;
    bottom: 18px;
    z-index: 1080;
    max-width: min(360px, calc(100vw - 36px));
    border: 1px solid rgba(200, 161, 101, 0.28);
    border-radius: 8px;
    color: #fff;
    background: linear-gradient(135deg, var(--cart-green), var(--cart-green-light));
    box-shadow: var(--cart-shadow);
    padding: 13px 16px;
    opacity: 0;
    transform: translateY(12px);
    pointer-events: none;
    transition: opacity 0.22s ease, transform 0.22s ease;
}

.cart-toast.show {
    opacity: 1;
    transform: translateY(0);
}

.cart-empty-card {
    position: relative;
    overflow: hidden;
    max-width: 760px;
    margin: 0 auto;
    padding: clamp(34px, 6vw, 64px);
}

.cart-empty-icon {
    width: 86px;
    height: 86px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #fff;
    background: linear-gradient(135deg, var(--cart-green), var(--cart-green-light));
    box-shadow: 0 18px 34px rgba(26, 60, 46, 0.2);
    margin-bottom: 22px;
}

@media (max-width: 991.98px) {
    .cart-hero {
        margin-top: 0;
        min-height: auto;
    }

    .cart-hero-content {
        padding: 108px 0 96px;
    }

    .cart-shell {
        margin-top: 0;
        padding-top: 42px;
    }

    .cart-summary {
        position: static;
    }
}

@media (max-width: 575.98px) {
    .cart-hero h1 {
        font-size: 2.4rem;
    }

    .cart-progress,
    .cart-trust-grid {
        grid-template-columns: 1fr;
    }

    .cart-panel-header {
        align-items: flex-start;
        flex-direction: column;
    }
}
</style>
@endpush

@section('content')
<main class="cart-page">
    <section class="cart-hero">
        <div class="container">
            <div class="cart-hero-content">
                <span class="cart-badge">
                    <i class="fas fa-basket-shopping"></i>
                    {{ __('Dawakhana Cart') }}
                </span>
                <h1 class="display-4 mb-3">{{ __('Shopping Cart') }}</h1>
                <p class="lead mb-0">{{ __('Review your herbal products, adjust quantities, apply coupon savings, and continue to a secure checkout.') }}</p>
            </div>
        </div>
    </section>

    <section class="cart-shell">
        <div class="container">
            @if($cartItems->count() > 0)
                <div class="cart-progress">
                    <div class="cart-step active">
                        <span class="cart-step-icon"><i class="fas fa-basket-shopping"></i></span>
                        <div>
                            <strong class="d-block">{{ __('Cart') }}</strong>
                            <small>{{ __('Review items') }}</small>
                        </div>
                    </div>
                    <div class="cart-step">
                        <span class="cart-step-icon"><i class="fas fa-truck-fast"></i></span>
                        <div>
                            <strong class="d-block">{{ __('Checkout') }}</strong>
                            <small>{{ __('Delivery details') }}</small>
                        </div>
                    </div>
                    <div class="cart-step">
                        <span class="cart-step-icon"><i class="fas fa-shield-halved"></i></span>
                        <div>
                            <strong class="d-block">{{ __('Confirm') }}</strong>
                            <small>{{ __('Secure order') }}</small>
                        </div>
                    </div>
                </div>

                <div class="row g-4 g-lg-5">
                    <div class="col-lg-8">
                        <div class="cart-panel">
                            <div class="cart-panel-header">
                                <div>
                                    <h2 class="cart-title h1">{{ __('Your Herbal Basket') }}</h2>
                                    <p class="text-muted mb-0 mt-2">{{ __('You have') }} <strong>{{ $cartItems->count() }}</strong> {{ __('item(s) ready for checkout.') }}</p>
                                </div>
                                <a href="{{ route('shop.index') }}" class="btn cart-shop-btn px-4">
                                    <i class="fas fa-arrow-left me-2"></i>{{ __('Continue Shopping') }}
                                </a>
                            </div>

                            <div class="table-responsive d-none d-md-block">
                                <table class="table align-middle text-center cart-table">
                                    <thead>
                                        <tr>
                                            <th class="py-3 px-4 text-start">{{ __('Product') }}</th>
                                            <th class="py-3">{{ __('Price') }}</th>
                                            <th class="py-3">{{ __('Quantity') }}</th>
                                            <th class="py-3">{{ __('Subtotal') }}</th>
                                            <th class="py-3"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $item)
                                            @php
                                                $price = $item->product->sale_price ?: $item->product->price;
                                                $itemSubtotal = $price * $item->quantity;
                                            @endphp
                                            <tr data-cart-id="{{ $item->id }}" data-price="{{ $price }}">
                                                <td class="text-start p-4">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="{{ asset($item->product->main_image) }}" loading="lazy" class="cart-product-img" alt="{{ $item->product->name }}">
                                                        <div>
                                                            <h6 class="fw-bold mb-2">
                                                                <a href="{{ route('product.show', $item->product->slug) }}" class="cart-product-link">{{ $item->product->name }}</a>
                                                            </h6>
                                                            <div class="d-flex flex-wrap gap-2">
                                                                <span class="cart-category-pill"><i class="fas fa-leaf"></i>{{ $item->product->category->name ?? __('Uncategorized') }}</span>
                                                                <span class="cart-stock-pill"><i class="fas fa-box"></i>{{ $item->product->stock_quantity }} {{ __('in stock') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-muted">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($price, 2) }}</td>
                                                <td>
                                                    <div class="input-group cart-qty mx-auto">
                                                        <button class="btn update-qty-btn" data-action="minus" type="button" aria-label="{{ __('Decrease quantity') }}">-</button>
                                                        <input type="text" class="form-control text-center bg-white qty-input" value="{{ $item->quantity }}" data-max="{{ $item->product->stock_quantity }}" readonly>
                                                        <button class="btn update-qty-btn" data-action="plus" type="button" aria-label="{{ __('Increase quantity') }}">+</button>
                                                    </div>
                                                </td>
                                                <td class="fw-bold fs-5 row-subtotal" style="color: var(--cart-green);">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($itemSubtotal, 2) }}</td>
                                                <td>
                                                    <button class="btn remove-cart-btn" aria-label="{{ __('Remove item') }}"><i class="fas fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-md-none p-3">
                                @foreach($cartItems as $item)
                                    @php
                                        $price = $item->product->sale_price ?: $item->product->price;
                                        $itemSubtotal = $price * $item->quantity;
                                    @endphp
                                    <div class="cart-mobile-card mb-3" data-cart-id="{{ $item->id }}" data-price="{{ $price }}">
                                        <div class="p-3">
                                            <div class="d-flex gap-3 mb-3">
                                                <img src="{{ asset($item->product->main_image) }}" loading="lazy" class="cart-product-img" alt="{{ $item->product->name }}">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between gap-2">
                                                        <div>
                                                            <h6 class="fw-bold mb-2">
                                                                <a href="{{ route('product.show', $item->product->slug) }}" class="cart-product-link">{{ $item->product->name }}</a>
                                                            </h6>
                                                            <span class="cart-category-pill"><i class="fas fa-leaf"></i>{{ $item->product->category->name ?? __('Uncategorized') }}</span>
                                                        </div>
                                                        <button class="btn remove-cart-btn flex-shrink-0" aria-label="{{ __('Remove item') }}"><i class="fas fa-trash-alt"></i></button>
                                                    </div>
                                                    <div class="fw-bold text-muted small mt-2">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($price, 2) }} {{ __('each') }}</div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center p-2 rounded-3" style="background: rgba(200, 161, 101, 0.09);">
                                                <div class="input-group cart-qty">
                                                    <button class="btn update-qty-btn" data-action="minus" type="button" aria-label="{{ __('Decrease quantity') }}">-</button>
                                                    <input type="text" class="form-control text-center bg-white qty-input px-1" value="{{ $item->quantity }}" data-max="{{ $item->product->stock_quantity }}" readonly>
                                                    <button class="btn update-qty-btn" data-action="plus" type="button" aria-label="{{ __('Increase quantity') }}">+</button>
                                                </div>
                                                <div class="text-end">
                                                    <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem;">{{ __('Subtotal') }}</small>
                                                    <span class="fw-bold row-subtotal" style="color: var(--cart-green);">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($itemSubtotal, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <a href="{{ route('shop.index') }}" class="btn cart-shop-btn w-100 mt-2">
                                    <i class="fas fa-arrow-left me-2"></i>{{ __('Continue Shopping') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <aside class="cart-summary">
                            <div class="p-4 p-lg-5">
                                <span class="cart-badge mb-3" style="color: var(--cart-green); background: rgba(200, 161, 101, 0.12); border-color: rgba(200, 161, 101, 0.3);">
                                    <i class="fas fa-receipt"></i>{{ __('Order Summary') }}
                                </span>
                                <h2 class="playfair fw-bold mb-4 cart-summary-title">{{ __('Checkout Details') }}</h2>

                                <div class="cart-summary-row">
                                    <span>{{ __('Subtotal') }}</span>
                                    <span id="summary-subtotal">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($subtotal, 2) }}</span>
                                </div>

                                <div class="cart-summary-row text-success {{ $discount > 0 ? '' : 'd-none' }}" id="summary-discount-row">
                                    <span>{{ __('Discount') }} <small id="applied-coupon-code" class="text-muted ms-1">{{ $coupon ? '('.$coupon->code.')' : '' }}</small></span>
                                    <span id="summary-discount">-{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($discount, 2) }}</span>
                                </div>

                                <div class="cart-summary-row">
                                    <span>{{ __('Shipping Estimate') }}</span>
                                    <span id="summary-shipping">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($shipping, 2) }}</span>
                                </div>

                                <div class="cart-summary-row">
                                    <span>{{ __('Estimated Tax') }}</span>
                                    <span id="summary-tax">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($tax, 2) }}</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center cart-total-row mb-4">
                                    <h5 class="fw-bold mb-0 cart-total-label">{{ __('Total') }}</h5>
                                    <h3 class="fw-bold mb-0" id="summary-total">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($total, 2) }}</h3>
                                </div>

                                <div id="coupon-alert" class="alert alert-danger d-none small py-2 mb-3"></div>

                                <form class="coupon-box mb-4" id="coupon-form">
                                    @if($coupon)
                                        <div class="d-flex align-items-center justify-content-between gap-3">
                                            <span class="small fw-bold text-success"><i class="fas fa-tag me-1"></i>{{ __('Coupon applied') }}</span>
                                            <button class="btn btn-outline-danger btn-sm fw-bold" style="border-radius: 8px;" type="button" id="remove-coupon-btn">{{ __('Remove') }}</button>
                                        </div>
                                    @else
                                        <label class="small fw-bold text-uppercase mb-2" for="coupon-code-input" style="color: var(--cart-green);">{{ __('Have a coupon?') }}</label>
                                        <div class="input-group">
                                            <input type="text" name="code" id="coupon-code-input" class="form-control coupon-input" placeholder="{{ __('Coupon Code') }}">
                                            <button class="btn coupon-btn px-4" type="submit" id="coupon-apply-btn">{{ __('Apply') }}</button>
                                        </div>
                                    @endif
                                </form>

                                <a href="{{ route('checkout.index') }}" class="btn cart-checkout-btn w-100 mb-3 d-flex align-items-center justify-content-center gap-2">
                                    {{ __('Proceed to Checkout') }} <i class="fas fa-arrow-right"></i>
                                </a>

                                <div class="cart-trust-grid">
                                    <span class="cart-trust-chip"><i class="fas fa-lock"></i>{{ __('Secure') }}</span>
                                    <span class="cart-trust-chip"><i class="fas fa-leaf"></i>{{ __('Herbal') }}</span>
                                    <span class="cart-trust-chip"><i class="fas fa-truck-fast"></i>{{ __('Delivery') }}</span>
                                </div>

                                <div class="cart-protection-note">
                                    <i class="fas fa-shield-heart"></i>
                                    <span>{{ __('Order protection: your herbal products are checked before dispatch, and checkout stays protected with secure session handling.') }}</span>
                                </div>

                                <div class="text-center mt-4">
                                    <p class="text-muted mb-2 small text-uppercase fw-bold">{{ __('We Accept') }}</p>
                                    <div class="d-flex justify-content-center gap-2 fs-3 text-muted opacity-75">
                                        <i class="fab fa-cc-visa"></i>
                                        <i class="fab fa-cc-mastercard"></i>
                                        <i class="fas fa-money-bill-wave"></i>
                                        <i class="fas fa-building-columns"></i>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            @else
                <div class="cart-empty-card text-center">
                    <span class="cart-empty-icon">
                        <i class="fas fa-shopping-basket fa-2x"></i>
                    </span>
                    <span class="cart-badge" style="color: var(--cart-green); background: rgba(200, 161, 101, 0.12); border-color: rgba(200, 161, 101, 0.3);">
                        <i class="fas fa-leaf"></i>{{ __('Start Wellness Shopping') }}
                    </span>
                    <h2 class="playfair fw-bold mt-3 mb-3">{{ __('Your cart is currently empty') }}</h2>
                    <p class="text-muted mb-4">{{ __('Explore Dawakhana products and add trusted herbal care items before continuing to checkout.') }}</p>
                    <a href="{{ route('shop.index') }}" class="btn cart-checkout-btn btn-lg px-5">
                        {{ __('Return To Shop') }} <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>
</main>

<div class="cart-toast" id="cart-toast"></div>

<div class="cart-modal-backdrop" id="remove-cart-modal" aria-hidden="true">
    <div class="cart-remove-modal" role="dialog" aria-modal="true" aria-labelledby="remove-cart-title">
        <div class="cart-remove-modal-header text-center">
            <span class="cart-remove-modal-icon">
                <i class="fas fa-trash-alt"></i>
            </span>
            <h3 class="playfair fw-bold mb-1" id="remove-cart-title">{{ __('Remove this item?') }}</h3>
            <p class="mb-0 small" style="color: rgba(255,255,255,0.78);">{{ __('You can always add it again from the shop.') }}</p>
        </div>
        <div class="cart-remove-modal-body">
            <p class="text-muted mb-4">{{ __('This product will be removed from your Dawakhana cart and your order total will update automatically.') }}</p>
            <div class="cart-modal-actions">
                <button type="button" class="btn cart-modal-cancel" id="cancel-remove-cart">{{ __('Keep Item') }}</button>
                <button type="button" class="btn cart-modal-confirm" id="confirm-remove-cart">{{ __('Remove Item') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';
    const toast = document.getElementById('cart-toast');
    const removeModal = document.getElementById('remove-cart-modal');
    const cancelRemoveBtn = document.getElementById('cancel-remove-cart');
    const confirmRemoveBtn = document.getElementById('confirm-remove-cart');
    let pendingRemoveRow = null;
    let toastTimer;

    const routes = {
        update: "{{ route('cart.update') }}",
        remove: "{{ route('cart.remove') }}",
        applyCoupon: "{{ route('cart.coupon.apply') }}",
        removeCoupon: "{{ route('cart.coupon.remove') }}"
    };

    function showToast(message) {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => toast.classList.remove('show'), 2600);
    }

    function setLoading(button, isLoading) {
        if (!button) return;
        button.disabled = isLoading;
        button.classList.toggle('opacity-75', isLoading);
    }

    function setRowUpdating(row, isUpdating) {
        if (!row) return;
        row.classList.toggle('is-updating', isUpdating);
    }

    function openRemoveModal(row) {
        pendingRemoveRow = row;
        if (!removeModal) return;
        removeModal.classList.add('show');
        removeModal.setAttribute('aria-hidden', 'false');
        if (confirmRemoveBtn) confirmRemoveBtn.focus();
    }

    function closeRemoveModal() {
        pendingRemoveRow = null;
        if (!removeModal) return;
        removeModal.classList.remove('show');
        removeModal.setAttribute('aria-hidden', 'true');
    }

    function removeCartRow(row) {
        if (!row) return;

        const cartId = row.getAttribute('data-cart-id');
        setRowUpdating(row, true);
        setLoading(confirmRemoveBtn, true);

        fetch(routes.remove, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ cart_id: cartId })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                row.remove();
                const badges = document.querySelectorAll('.cart-count-badge');
                badges.forEach(b => b.innerText = data.count);
                applyDataToView(data);
                closeRemoveModal();
                showToast(data.success);
            }
        })
        .catch(err => {
            console.error("Remove error: ", err);
            showToast("{{ __('Could not remove item. Please try again.') }}");
        })
        .finally(() => {
            setRowUpdating(row, false);
            setLoading(confirmRemoveBtn, false);
        });
    }

    function applyDataToView(data) {
        if(data.subtotal === 0) {
            window.location.reload();
            return;
        }

        document.getElementById('summary-subtotal').innerText = window.currencySymbol + data.subtotal.toFixed(2);
        document.getElementById('summary-shipping').innerText = window.currencySymbol + data.shipping.toFixed(2);
        document.getElementById('summary-tax').innerText = window.currencySymbol + data.tax.toFixed(2);
        document.getElementById('summary-total').innerText = window.currencySymbol + data.total.toFixed(2);

        const discountRow = document.getElementById('summary-discount-row');
        if(data.discount > 0) {
            discountRow.classList.remove('d-none');
            document.getElementById('summary-discount').innerText = '-' + window.currencySymbol + data.discount.toFixed(2);
            if(data.coupon) {
                document.getElementById('applied-coupon-code').innerText = '(' + data.coupon.code + ')';
            }
        } else {
            discountRow.classList.add('d-none');
        }
    }

    document.querySelectorAll('.update-qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('[data-cart-id]');
            const cartId = row.getAttribute('data-cart-id');
            const input = row.querySelector('.qty-input');
            const max = parseInt(input.getAttribute('data-max'));
            let qty = parseInt(input.value);
            const oldQty = qty;

            if (this.getAttribute('data-action') === 'plus') {
                if(qty < max) qty++;
                else {
                    showToast("{{ __('Stock limit reached for this product.') }}");
                    return;
                }
            } else {
                if(qty > 1) qty--;
                else return;
            }

            input.value = qty;
            const price = parseFloat(row.getAttribute('data-price'));
            row.querySelector('.row-subtotal').innerText = window.currencySymbol + (price * qty).toFixed(2);
            setLoading(this, true);
            setRowUpdating(row, true);

            fetch(routes.update, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ cart_id: cartId, quantity: qty })
            })
            .then(res => res.json())
            .then(data => {
                if(data.error) {
                    input.value = oldQty;
                    row.querySelector('.row-subtotal').innerText = window.currencySymbol + (price * oldQty).toFixed(2);
                    showToast(data.error);
                } else {
                    applyDataToView(data);
                    showToast(data.success || "{{ __('Cart updated.') }}");
                }
            })
            .catch(err => {
                input.value = oldQty;
                row.querySelector('.row-subtotal').innerText = window.currencySymbol + (price * oldQty).toFixed(2);
                console.error("Update error: ", err);
                showToast("{{ __('Could not update cart. Please try again.') }}");
            })
            .finally(() => {
                setLoading(this, false);
                setRowUpdating(row, false);
            });
        });
    });

    document.querySelectorAll('.remove-cart-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('[data-cart-id]');
            openRemoveModal(row);
        });
    });

    if (cancelRemoveBtn) {
        cancelRemoveBtn.addEventListener('click', closeRemoveModal);
    }

    if (confirmRemoveBtn) {
        confirmRemoveBtn.addEventListener('click', function () {
            removeCartRow(pendingRemoveRow);
        });
    }

    if (removeModal) {
        removeModal.addEventListener('click', function (event) {
            if (event.target === removeModal) closeRemoveModal();
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && removeModal && removeModal.classList.contains('show')) {
            closeRemoveModal();
        }
    });

    const couponForm = document.getElementById('coupon-form');
    if(couponForm) {
        couponForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const alertBox = document.getElementById('coupon-alert');
            const codeInput = document.getElementById('coupon-code-input');
            const applyButton = document.getElementById('coupon-apply-btn');
            if(!codeInput || !codeInput.value.trim()) return;

            alertBox.classList.add('d-none');
            setLoading(applyButton, true);

            fetch(routes.applyCoupon, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ code: codeInput.value.trim() })
            })
            .then(res => res.json())
            .then(data => {
                if(data.error) {
                    alertBox.innerText = data.error;
                    alertBox.classList.remove('d-none');
                    showToast(data.error);
                } else {
                    showToast(data.success || "{{ __('Coupon applied.') }}");
                    window.location.reload();
                }
            })
            .catch(err => {
                console.error("Coupon error: ", err);
                showToast("{{ __('Could not apply coupon. Please try again.') }}");
            })
            .finally(() => setLoading(applyButton, false));
        });
    }

    const removeCouponBtn = document.getElementById('remove-coupon-btn');
    if(removeCouponBtn) {
        removeCouponBtn.addEventListener('click', function(e) {
            e.preventDefault();
            setLoading(removeCouponBtn, true);
            fetch(routes.removeCoupon, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                showToast(data.success || "{{ __('Coupon removed.') }}");
                window.location.reload();
            })
            .catch(err => {
                console.error("Coupon remove error: ", err);
                showToast("{{ __('Could not remove coupon. Please try again.') }}");
            })
            .finally(() => setLoading(removeCouponBtn, false));
        });
    }
});
</script>
@endpush
