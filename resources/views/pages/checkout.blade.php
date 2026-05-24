@extends('layouts.app')

@push('styles')
<style>
    .checkout-page {
        --checkout-green: var(--primary, #1a3c2e);
        --checkout-gold: var(--secondary, #c8a165);
        --checkout-cream: #f8f5f0;
        --checkout-ink: #21352b;
        color: var(--checkout-ink);
        background:
            radial-gradient(circle at 8% 8%, rgba(200, 161, 101, 0.13), transparent 28%),
            linear-gradient(180deg, #fff 0%, var(--checkout-cream) 100%);
    }

    .checkout-hero {
        position: relative;
        padding: 128px 0 70px;
        margin-top: 50px;
        color: #fff;
        background:
            linear-gradient(120deg, rgba(9, 24, 18, 0.96), rgba(26, 60, 46, 0.9)),
            url('https://images.unsplash.com/photo-1471193945509-9ad0617afabf?q=80&w=1920&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        overflow: hidden;
    }

    .checkout-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(200, 161, 101, 0.16), transparent 58%);
    }

    .checkout-hero > .container {
        position: relative;
        z-index: 1;
    }

    .checkout-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(200, 161, 101, 0.42);
        border-radius: 50px;
        padding: 8px 16px;
        color: #f2d39d;
        background: rgba(255, 255, 255, 0.08);
        font-size: 0.74rem;
        font-weight: 850;
        letter-spacing: 1.8px;
        text-transform: uppercase;
        backdrop-filter: blur(12px);
    }

    .checkout-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.4rem, 5vw, 4.4rem);
        line-height: 1.04;
    }

    .checkout-steps {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        margin-top: 32px;
    }

    .checkout-step-pill {
        display: flex;
        align-items: center;
        gap: 11px;
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 8px;
        padding: 12px 14px;
        color: rgba(255, 255, 255, 0.86);
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        font-size: 0.86rem;
        font-weight: 800;
    }

    .checkout-step-pill span {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        border-radius: 50%;
        color: var(--checkout-green);
        background: linear-gradient(135deg, var(--checkout-gold), #e2c08d);
    }

    .checkout-card {
        position: relative;
        border: 1px solid rgba(26, 60, 46, 0.08);
        border-radius: 8px;
        padding: 28px;
        background: rgba(255, 255, 255, 0.96);
        box-shadow: 0 16px 42px rgba(26, 60, 46, 0.09);
        overflow: hidden;
    }

    .checkout-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 28px;
        right: 28px;
        height: 3px;
        border-radius: 0 0 8px 8px;
        background: linear-gradient(90deg, var(--checkout-gold), transparent);
    }

    .checkout-section-head {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 24px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(26, 60, 46, 0.08);
    }

    .checkout-section-icon {
        width: 46px;
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        border-radius: 50%;
        color: var(--checkout-green);
        background: rgba(200, 161, 101, 0.17);
    }

    .checkout-section-title {
        font-family: 'Playfair Display', serif;
        color: var(--checkout-green);
        font-weight: 800;
    }

    .checkout-label {
        color: #68746d;
        font-size: 0.74rem;
        font-weight: 850;
        letter-spacing: 1.1px;
        text-transform: uppercase;
    }

    .checkout-input,
    .checkout-select,
    .checkout-textarea {
        border: 1px solid rgba(26, 60, 46, 0.12) !important;
        border-radius: 8px !important;
        padding: 12px 15px !important;
        color: #22342b !important;
        background: #fff !important;
        box-shadow: none !important;
        transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
    }

    .checkout-input:focus,
    .checkout-select:focus,
    .checkout-textarea:focus {
        border-color: rgba(200, 161, 101, 0.58) !important;
        box-shadow: 0 0 0 4px rgba(200, 161, 101, 0.13) !important;
        transform: translateY(-1px);
    }

    .checkout-helper {
        color: #7b877f;
        font-size: 0.82rem;
        line-height: 1.6;
    }

    .checkout-trust-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
    }

    .checkout-trust-item {
        border: 1px solid rgba(26, 60, 46, 0.08);
        border-radius: 8px;
        padding: 14px 12px;
        text-align: center;
        background: #fff;
        box-shadow: 0 10px 26px rgba(26, 60, 46, 0.06);
        font-size: 0.76rem;
        font-weight: 850;
        color: var(--checkout-green);
    }

    .checkout-trust-item i {
        display: block;
        color: var(--checkout-gold);
        font-size: 1.1rem;
        margin-bottom: 7px;
    }

    .checkout-payment-option {
        border: 1px solid rgba(26, 60, 46, 0.1);
        border-radius: 8px;
        background: #fff;
        overflow: hidden;
        transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
    }

    .checkout-payment-option + .checkout-payment-option {
        margin-top: 14px;
    }

    .checkout-payment-option:hover,
    .checkout-payment-option.is-selected {
        border-color: rgba(200, 161, 101, 0.5);
        box-shadow: 0 16px 34px rgba(26, 60, 46, 0.1);
        transform: translateY(-2px);
    }

    .checkout-payment-head {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 18px;
        cursor: pointer;
        background: linear-gradient(135deg, #fff 0%, rgba(248, 245, 240, 0.78) 100%);
    }

    .checkout-payment-icon {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        border-radius: 50%;
        color: var(--checkout-green);
        background: rgba(200, 161, 101, 0.17);
        font-size: 1.1rem;
    }

    .checkout-payment-option .form-check-input {
        box-shadow: none !important;
        cursor: pointer;
    }

    .checkout-payment-option .form-check-input:checked {
        background-color: var(--checkout-green);
        border-color: var(--checkout-green);
    }

    .checkout-payment-body {
        padding: 20px;
        border-top: 1px solid rgba(26, 60, 46, 0.08);
    }

    .checkout-summary {
        position: sticky;
        top: 118px;
        border: 1px solid rgba(26, 60, 46, 0.08);
        border-radius: 8px;
        background:
            linear-gradient(180deg, #fff 0%, #fff 65%, rgba(248, 245, 240, 0.82) 100%);
        box-shadow: 0 20px 55px rgba(26, 60, 46, 0.13);
        overflow: hidden;
    }

    .checkout-summary-head {
        padding: 24px 26px;
        color: #fff;
        background: linear-gradient(135deg, var(--checkout-green), #2d6a4f);
    }

    .checkout-summary-body {
        padding: 26px;
    }

    .checkout-order-items {
        max-height: 315px;
        overflow-y: auto;
        padding-right: 6px;
    }

    .checkout-order-item {
        display: flex;
        gap: 14px;
        padding-bottom: 16px;
        margin-bottom: 16px;
        border-bottom: 1px solid rgba(26, 60, 46, 0.08);
    }

    .checkout-order-img {
        width: 68px;
        height: 68px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 8px 20px rgba(26, 60, 46, 0.12);
    }

    .checkout-qty {
        position: absolute;
        top: -8px;
        right: -8px;
        min-width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: var(--checkout-green);
        background: linear-gradient(135deg, var(--checkout-gold), #e2c08d);
        font-size: 0.72rem;
        font-weight: 900;
    }

    .checkout-total-box {
        border-top: 1px solid rgba(26, 60, 46, 0.08);
        margin-top: 18px;
        padding-top: 20px;
    }

    .checkout-total-amount {
        color: var(--checkout-green);
        font-size: clamp(1.8rem, 4vw, 2.35rem);
        font-weight: 900;
    }

    .checkout-submit {
        border: 0;
        border-radius: 50px;
        padding: 15px 24px;
        color: #fff;
        background: linear-gradient(135deg, var(--checkout-green), #2d6a4f);
        font-weight: 900;
        box-shadow: 0 16px 35px rgba(26, 60, 46, 0.25);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .checkout-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 22px 45px rgba(26, 60, 46, 0.3);
    }

    .checkout-secure-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #6d7a72;
        font-size: 0.82rem;
        line-height: 1.6;
    }

    @media (max-width: 991.98px) {
        .checkout-hero {
            margin-top: 0;
            padding: 112px 0 58px;
        }

        .checkout-summary {
            position: static;
        }
    }

    @media (max-width: 767.98px) {
        .checkout-page .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .checkout-steps,
        .checkout-trust-grid {
            grid-template-columns: 1fr;
        }

        .checkout-card,
        .checkout-summary-body {
            padding: 20px;
        }

        .checkout-section-head {
            gap: 11px;
        }

        .checkout-payment-head {
            align-items: flex-start;
            padding: 16px;
        }

        .checkout-payment-body {
            padding: 16px;
        }

        .checkout-summary-head {
            padding: 22px 20px;
        }

        .checkout-order-img {
            width: 62px;
            height: 62px;
        }
    }

    @media (max-width: 390px) {
        .checkout-hero {
            padding: 96px 0 46px;
        }

        .checkout-badge {
            font-size: 0.66rem;
            letter-spacing: 1.2px;
            padding: 7px 12px;
        }

        .checkout-card,
        .checkout-summary-body {
            padding: 18px;
        }

        .checkout-section-title {
            font-size: 1.2rem;
        }
    }
</style>
@endpush

@section('content')
    @php
        $hasCard = !empty($globalSettings['payment_card_enabled']);
        $hasCod = !empty($globalSettings['payment_cod_enabled']);
        $hasWa = !empty($globalSettings['payment_whatsapp_enabled']);
        $defaultMethod = 'credit_card';

        if (!$hasCard) {
            if ($hasCod) {
                $defaultMethod = 'cod';
            } elseif ($hasWa) {
                $defaultMethod = 'whatsapp';
            }
        }

        $selectedPayment = old('payment_method', $defaultMethod);
        $hasPaymentMethod = $hasCard || $hasCod || $hasWa;
        $itemCount = $cartItems->sum('quantity');
    @endphp

    <main class="checkout-page min-vh-100">
        <section class="checkout-hero">
            <div class="container">
                <div class="row align-items-end g-4">
                    <div class="col-lg-7">
                        <span class="checkout-badge mb-3">
                            <i class="fas fa-shield-heart"></i>
                            {{ __('Secure Checkout') }}
                        </span>
                        <h1 class="checkout-title fw-bold mb-3">{{ __('Complete your herbal wellness order') }}</h1>
                        <p class="text-white-50 mb-0" style="max-width: 650px; line-height: 1.85;">
                            {{ __('Your details stay protected while we prepare your Dawakhana products with care.') }}
                        </p>
                    </div>
                    <div class="col-lg-5">
                        <div class="checkout-steps">
                            <div class="checkout-step-pill"><span>1</span>{{ __('Contact') }}</div>
                            <div class="checkout-step-pill"><span>2</span>{{ __('Delivery') }}</div>
                            <div class="checkout-step-pill"><span>3</span>{{ __('Payment') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container py-2 py-lg-4">
                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('checkout.placeOrder') }}" method="POST">
                    @csrf
                    <div class="row g-4 g-xl-5">
                        <div class="col-lg-7">
                            <div class="checkout-trust-grid mb-4">
                                <div class="checkout-trust-item">
                                    <i class="fas fa-lock"></i>
                                    {{ __('Secure Data') }}
                                </div>
                                <div class="checkout-trust-item">
                                    <i class="fas fa-box-open"></i>
                                    {{ __('Careful Packing') }}
                                </div>
                                <div class="checkout-trust-item">
                                    <i class="fas fa-headset"></i>
                                    {{ __('Order Support') }}
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <div class="checkout-card mb-4">
                                <div class="checkout-section-head">
                                    <span class="checkout-section-icon"><i class="fas fa-id-card"></i></span>
                                    <div>
                                        <h4 class="checkout-section-title mb-1">1. {{ __('Contact Info') }}</h4>
                                        <p class="checkout-helper mb-0">{{ __('We will use this information for order updates and delivery coordination.') }}</p>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label checkout-label">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="shipping_name" class="form-control checkout-input @error('shipping_name') is-invalid @enderror" required value="{{ old('shipping_name', auth()->user()->name ?? '') }}" placeholder="{{ __('John Doe') }}">
                                        @error('shipping_name') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label checkout-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                        <input type="email" name="shipping_email" class="form-control checkout-input @error('shipping_email') is-invalid @enderror" required value="{{ old('shipping_email', auth()->user()->email ?? '') }}" placeholder="john@example.com">
                                        @error('shipping_email') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label checkout-label">{{ __('Phone') }}</label>
                                        <input type="tel" name="shipping_phone" class="form-control checkout-input @error('shipping_phone') is-invalid @enderror" value="{{ old('shipping_phone') }}" placeholder="(555) 000-0000">
                                        @error('shipping_phone') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Address -->
                            <div class="checkout-card mb-4">
                                <div class="checkout-section-head">
                                    <span class="checkout-section-icon"><i class="fas fa-map-location-dot"></i></span>
                                    <div>
                                        <h4 class="checkout-section-title mb-1">2. {{ __('Shipping Address') }}</h4>
                                        <p class="checkout-helper mb-0">{{ __('Add the address where your herbal products should be delivered.') }}</p>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label checkout-label">{{ __('Street Address') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="shipping_address" class="form-control checkout-input @error('shipping_address') is-invalid @enderror" required value="{{ old('shipping_address') }}" placeholder="123 Main St">
                                        @error('shipping_address') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label checkout-label">{{ __('City') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="shipping_city" class="form-control checkout-input @error('shipping_city') is-invalid @enderror" required value="{{ old('shipping_city') }}">
                                        @error('shipping_city') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label checkout-label">{{ __('State/Province') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="shipping_state" class="form-control checkout-input @error('shipping_state') is-invalid @enderror" required value="{{ old('shipping_state') }}">
                                        @error('shipping_state') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label checkout-label">{{ __('Zip Code') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="shipping_zip" class="form-control checkout-input @error('shipping_zip') is-invalid @enderror" required value="{{ old('shipping_zip') }}">
                                        @error('shipping_zip') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label checkout-label">{{ __('Country') }} <span class="text-danger">*</span></label>
                                        <select name="shipping_country" class="form-select checkout-select @error('shipping_country') is-invalid @enderror" required>
                                            <option value="US" {{ old('shipping_country') == 'US' ? 'selected' : '' }}>{{ __('United States') }}</option>
                                            <option value="CA" {{ old('shipping_country') == 'CA' ? 'selected' : '' }}>{{ __('Canada') }}</option>
                                            <option value="GB" {{ old('shipping_country') == 'GB' ? 'selected' : '' }}>{{ __('United Kingdom') }}</option>
                                            <option value="PK" {{ old('shipping_country') == 'PK' ? 'selected' : '' }}>{{ __('Pakistan') }}</option>
                                        </select>
                                        @error('shipping_country') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label checkout-label">{{ __('Order Notes (Optional)') }}</label>
                                        <textarea name="notes" class="form-control checkout-textarea" rows="3" placeholder="{{ __('Any delivery note or product instruction...') }}">{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="checkout-card mb-4">
                                <div class="checkout-section-head">
                                    <span class="checkout-section-icon"><i class="fas fa-credit-card"></i></span>
                                    <div>
                                        <h4 class="checkout-section-title mb-1">3. {{ __('Payment') }}</h4>
                                        <p class="checkout-helper mb-0">{{ __('Choose how you want to complete this order.') }}</p>
                                    </div>
                                </div>

                                <div id="paymentAccordion">
                                    @if($hasCard)
                                        <div class="checkout-payment-option {{ $selectedPayment == 'credit_card' ? 'is-selected' : '' }}" data-payment-option>
                                            <div class="checkout-payment-head">
                                                <input class="form-check-input mt-1" type="radio" name="payment_method" id="payment_cc" value="credit_card" {{ $selectedPayment == 'credit_card' ? 'checked' : '' }} onchange="togglePayment('cc')">
                                                <span class="checkout-payment-icon"><i class="far fa-credit-card"></i></span>
                                                <label class="form-check-label flex-grow-1" for="payment_cc">
                                                    <span class="d-block fw-bold text-primary-custom">{{ __('Credit Card') }}</span>
                                                    <small class="text-muted">{{ __('Pay securely with your card details.') }}</small>
                                                </label>
                                            </div>
                                            <div id="ccCollapse" class="collapse {{ $selectedPayment == 'credit_card' ? 'show' : '' }}">
                                                <div class="checkout-payment-body">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label checkout-label">{{ __('Card Number') }}</label>
                                                            <input type="text" name="card_number" inputmode="numeric" class="form-control checkout-input @error('card_number') is-invalid @enderror" value="{{ old('card_number') }}" placeholder="0000 0000 0000 0000">
                                                            @error('card_number') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label checkout-label">{{ __('Expiry (MM/YY)') }}</label>
                                                            <input type="text" name="expiry" class="form-control checkout-input @error('expiry') is-invalid @enderror" value="{{ old('expiry') }}" placeholder="MM/YY">
                                                            @error('expiry') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label checkout-label">{{ __('CVV') }}</label>
                                                            <input type="text" name="cvv" inputmode="numeric" class="form-control checkout-input @error('cvv') is-invalid @enderror" value="{{ old('cvv') }}" placeholder="123">
                                                            @error('cvv') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($hasCod)
                                        <div class="checkout-payment-option {{ $selectedPayment == 'cod' ? 'is-selected' : '' }}" data-payment-option>
                                            <div class="checkout-payment-head">
                                                <input class="form-check-input mt-1" type="radio" name="payment_method" id="payment_cod" value="cod" {{ $selectedPayment == 'cod' ? 'checked' : '' }} onchange="togglePayment('cod')">
                                                <span class="checkout-payment-icon"><i class="fas fa-money-bill-wave"></i></span>
                                                <label class="form-check-label flex-grow-1" for="payment_cod">
                                                    <span class="d-block fw-bold text-primary-custom">{{ __('Cash on Delivery') }}</span>
                                                    <small class="text-muted">{{ __('Pay when your order arrives at your address.') }}</small>
                                                </label>
                                            </div>
                                            <div id="codCollapse" class="collapse {{ $selectedPayment == 'cod' ? 'show' : '' }}">
                                                <div class="checkout-payment-body text-muted">
                                                    {{ __('Pay with cash when your order is delivered to your address.') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($hasWa)
                                        <div class="checkout-payment-option {{ $selectedPayment == 'whatsapp' ? 'is-selected' : '' }}" data-payment-option>
                                            <div class="checkout-payment-head">
                                                <input class="form-check-input mt-1" type="radio" name="payment_method" id="payment_whatsapp" value="whatsapp" {{ $selectedPayment == 'whatsapp' ? 'checked' : '' }} onchange="togglePayment('wa')">
                                                <span class="checkout-payment-icon"><i class="fab fa-whatsapp text-success"></i></span>
                                                <label class="form-check-label flex-grow-1" for="payment_whatsapp">
                                                    <span class="d-block fw-bold text-primary-custom">{{ __('Order via WhatsApp') }}</span>
                                                    <small class="text-muted">{{ __('Send order details directly for faster processing.') }}</small>
                                                </label>
                                            </div>
                                            <div id="waCollapse" class="collapse {{ $selectedPayment == 'whatsapp' ? 'show' : '' }}">
                                                <div class="checkout-payment-body text-muted">
                                                    {{ __('Place your order here first. You will then be redirected to WhatsApp to send your order details directly to us for faster processing.') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!$hasPaymentMethod)
                                        <div class="alert alert-warning border-0 rounded-3 mb-0">
                                            {{ __('No payment methods are currently enabled. Please contact support.') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <aside class="checkout-summary">
                                <div class="checkout-summary-head">
                                    <div class="d-flex align-items-center justify-content-between gap-3">
                                        <div>
                                            <span class="checkout-badge mb-2" style="font-size: 0.64rem; padding: 6px 11px;">{{ __('Order Summary') }}</span>
                                            <h4 class="playfair fw-bold mb-0">{{ __('Your Order') }}</h4>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold fs-4">{{ $itemCount }}</div>
                                            <small class="text-white-50">{{ __('Items') }}</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="checkout-summary-body">
                                    <div class="checkout-order-items custom-scrollbar mb-4">
                                        @foreach($cartItems as $item)
                                            @php
                                                $price = $item->product->sale_price ?: $item->product->price;
                                            @endphp
                                            <div class="checkout-order-item">
                                                <div class="position-relative flex-shrink-0">
                                                    <img src="{{ asset($item->product->main_image) }}" class="checkout-order-img" alt="{{ $item->product->name }}">
                                                    <span class="checkout-qty">{{ $item->quantity }}</span>
                                                </div>
                                                <div class="flex-grow-1 min-w-0">
                                                    <h6 class="fw-bold mb-1 small text-dark">{{ $item->product->name }}</h6>
                                                    <div class="text-muted small mb-1">{{ __('Qty') }}: {{ $item->quantity }}</div>
                                                    <div class="text-primary-custom fw-bold small">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($price * $item->quantity, 2) }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="d-flex justify-content-between mb-2 text-muted">
                                        <span>{{ __('Subtotal') }}</span>
                                        <span class="fw-bold text-dark">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($subtotal, 2) }}</span>
                                    </div>

                                    @if($discount > 0)
                                        <div class="d-flex justify-content-between mb-2 text-success">
                                            <span>{{ __('Discount') }} {{ $coupon ? '('.$coupon->code.')' : '' }}</span>
                                            <span class="fw-bold">-{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($discount, 2) }}</span>
                                        </div>
                                    @endif

                                    <div class="d-flex justify-content-between mb-2 text-muted">
                                        <span>{{ __('Shipping') }}</span>
                                        <span class="fw-bold text-dark">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($shipping, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 text-muted">
                                        <span>{{ __('Taxes') }}</span>
                                        <span class="fw-bold text-dark">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($tax, 2) }}</span>
                                    </div>

                                    <div class="checkout-total-box">
                                        <div class="d-flex justify-content-between align-items-end gap-3 mb-4">
                                            <h5 class="fw-bold mb-0">{{ __('Total') }}</h5>
                                            <div class="checkout-total-amount">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($total, 2) }}</div>
                                        </div>

                                        <button type="submit" class="checkout-submit w-100" {{ !$hasPaymentMethod ? 'disabled' : '' }}>
                                            {{ __('Place Order Securely') }} <i class="fas fa-lock ms-2"></i>
                                        </button>

                                        <p class="checkout-secure-note text-center mt-4 mb-0">
                                            <i class="fas fa-shield-alt"></i>
                                            {{ __('Your data is processed securely.') }}
                                        </p>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
<script>
    function togglePayment(mode) {
        const cc = document.getElementById('ccCollapse');
        const cod = document.getElementById('codCollapse');
        const wa = document.getElementById('waCollapse');

        if (cc) cc.classList.remove('show');
        if (cod) cod.classList.remove('show');
        if (wa) wa.classList.remove('show');

        if (mode === 'cc' && cc) cc.classList.add('show');
        if (mode === 'cod' && cod) cod.classList.add('show');
        if (mode === 'wa' && wa) wa.classList.add('show');

        document.querySelectorAll('[data-payment-option]').forEach(option => {
            const radio = option.querySelector('input[type="radio"]');
            option.classList.toggle('is-selected', radio && radio.checked);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-payment-option]').forEach(option => {
            option.addEventListener('click', function (event) {
                if (event.target.closest('input, label, select, textarea, button')) {
                    return;
                }

                const radio = option.querySelector('input[type="radio"]');
                if (radio && !radio.checked) {
                    radio.checked = true;
                    radio.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        });

        const checkedPayment = document.querySelector('input[name="payment_method"]:checked');
        if (checkedPayment) {
            checkedPayment.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });
</script>
@endpush
