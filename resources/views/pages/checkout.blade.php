@extends('layouts.app')

@section('content')
    <!-- Page Header (Hidden on Mobile) -->
    <div class="page-header text-center d-none d-md-block" style="background-color: var(--primary); padding: 80px 0 40px; margin-top: 50px; color: var(--white);">
        <div class="container pt-5">
            <h1 class="playfair display-4 mb-2">{{ __('Secure Checkout') }}</h1>
        </div>
    </div>

    <section class="py-5 bg-white min-vh-100">
        <div class="container py-4">
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.placeOrder') }}" method="POST">
                @csrf
                <div class="row g-5">
                    <div class="col-lg-7">
                        <!-- Contact Info -->
                        <div class="mb-5 border border-opacity-25 rounded-4 p-4 shadow-sm">
                            <h4 class="playfair fw-bold mb-4 border-bottom pb-2"><i class="fas fa-id-card me-2 text-secondary-custom"></i> 1. {{ __('Contact Info') }}</h4>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_name" class="form-control rounded-pill px-4 shadow-none py-2 @error('shipping_name') is-invalid @enderror" required value="{{ old('shipping_name', auth()->user()->name ?? '') }}" placeholder="{{ __('John Doe') }}">
                                    @error('shipping_name') <div class="invalid-feedback ps-3">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Email') }} <span class="text-danger">*</span></label>
                                    <input type="email" name="shipping_email" class="form-control rounded-pill px-4 shadow-none py-2 @error('shipping_email') is-invalid @enderror" required value="{{ old('shipping_email', auth()->user()->email ?? '') }}" placeholder="john@example.com">
                                    @error('shipping_email') <div class="invalid-feedback ps-3">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Phone') }}</label>
                                    <input type="tel" name="shipping_phone" class="form-control rounded-pill px-4 shadow-none py-2 @error('shipping_phone') is-invalid @enderror" value="{{ old('shipping_phone') }}" placeholder="(555) 000-0000">
                                    @error('shipping_phone') <div class="invalid-feedback ps-3">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="mb-5 border border-opacity-25 rounded-4 p-4 shadow-sm">
                            <h4 class="playfair fw-bold mb-4 border-bottom pb-2"><i class="fas fa-map-marker-alt me-2 text-secondary-custom"></i> 2. {{ __('Shipping Address') }}</h4>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Street Address') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_address" class="form-control rounded-pill px-4 shadow-none py-2 @error('shipping_address') is-invalid @enderror" required value="{{ old('shipping_address') }}" placeholder="123 Main St">
                                    @error('shipping_address') <div class="invalid-feedback ps-3">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label text-muted fw-bold small text-uppercase">{{ __('City') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_city" class="form-control rounded-pill px-4 shadow-none py-2 @error('shipping_city') is-invalid @enderror" required value="{{ old('shipping_city') }}">
                                    @error('shipping_city') <div class="invalid-feedback ps-3">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label text-muted fw-bold small text-uppercase">{{ __('State/Province') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_state" class="form-control rounded-pill px-4 shadow-none py-2 @error('shipping_state') is-invalid @enderror" required value="{{ old('shipping_state') }}">
                                    @error('shipping_state') <div class="invalid-feedback ps-3">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Zip Code') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_zip" class="form-control rounded-pill px-4 shadow-none py-2 @error('shipping_zip') is-invalid @enderror" required value="{{ old('shipping_zip') }}">
                                    @error('shipping_zip') <div class="invalid-feedback ps-3">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Country') }} <span class="text-danger">*</span></label>
                                    <select name="shipping_country" class="form-select rounded-pill px-4 shadow-none py-2 text-muted @error('shipping_country') is-invalid @enderror" required>
                                        <option value="US" {{ old('shipping_country') == 'US' ? 'selected' : '' }}>{{ __('United States') }}</option>
                                        <option value="CA" {{ old('shipping_country') == 'CA' ? 'selected' : '' }}>{{ __('Canada') }}</option>
                                        <option value="GB" {{ old('shipping_country') == 'GB' ? 'selected' : '' }}>{{ __('United Kingdom') }}</option>
                                        <option value="PK" {{ old('shipping_country') == 'PK' ? 'selected' : '' }}>{{ __('Pakistan') }}</option>
                                    </select>
                                    @error('shipping_country') <div class="invalid-feedback ps-3">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Order Notes (Optional)') }}</label>
                                    <textarea name="notes" class="form-control rounded-4 px-4 shadow-none py-2" rows="3">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-5 border border-opacity-25 rounded-4 p-4 shadow-sm">
                            <h4 class="playfair fw-bold mb-4 border-bottom pb-2"><i class="fas fa-credit-card me-2 text-secondary-custom"></i> 3. {{ __('Payment') }}</h4>
                            <div class="accordion" id="paymentAccordion">
                                @php
                                    $hasCard = !empty($globalSettings['payment_card_enabled']);
                                    $hasCod = !empty($globalSettings['payment_cod_enabled']);
                                    $hasWa = !empty($globalSettings['payment_whatsapp_enabled']);
                                    
                                    // Determine default selection
                                    $defaultMethod = 'credit_card';
                                    if (!$hasCard) {
                                        if ($hasCod) $defaultMethod = 'cod';
                                        elseif ($hasWa) $defaultMethod = 'whatsapp';
                                    }
                                @endphp

                                @if($hasCard)
                                <div class="accordion-item rounded-4 border overflow-hidden mb-3">
                                    <h2 class="accordion-header">
                                        <div class="accordion-button bg-light fw-bold py-3" style="cursor: pointer;">
                                            <div class="form-check w-100 mb-0">
                                                <input class="form-check-input" type="radio" name="payment_method" id="payment_cc" value="credit_card" {{ old('payment_method', $defaultMethod) == 'credit_card' ? 'checked' : '' }} onchange="togglePayment('cc')">
                                                <label class="form-check-label w-100 ms-2" for="payment_cc">
                                                    <i class="far fa-credit-card me-3 text-primary-custom fs-4"></i> {{ __('Credit Card') }}
                                                </label>
                                            </div>
                                        </div>
                                    </h2>
                                    <div id="ccCollapse" class="collapse {{ old('payment_method', $defaultMethod) == 'credit_card' ? 'show' : '' }}">
                                        <div class="accordion-body border-top">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label text-muted small fw-bold text-uppercase">{{ __('Card Number') }}</label>
                                                    <input type="text" name="card_number" class="form-control rounded-pill px-4 shadow-none py-2 @error('card_number') is-invalid @enderror" value="{{ old('card_number') }}" placeholder="0000 0000 0000 0000">
                                                    @error('card_number') <div class="invalid-feedback ps-3">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label text-muted small fw-bold text-uppercase">{{ __('Expiry (MM/YY)') }}</label>
                                                    <input type="text" name="expiry" class="form-control rounded-pill px-4 shadow-none py-2 @error('expiry') is-invalid @enderror" value="{{ old('expiry') }}" placeholder="MM/YY">
                                                    @error('expiry') <div class="invalid-feedback ps-3">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label text-muted small fw-bold text-uppercase">{{ __('CVV') }}</label>
                                                    <input type="text" name="cvv" class="form-control rounded-pill px-4 shadow-none py-2 @error('cvv') is-invalid @enderror" value="{{ old('cvv') }}" placeholder="123">
                                                    @error('cvv') <div class="invalid-feedback ps-3">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($hasCod)
                                <div class="accordion-item rounded-4 border overflow-hidden mb-3">
                                    <h2 class="accordion-header">
                                        <div class="accordion-button collapsed bg-light fw-bold py-3" style="cursor: pointer;">
                                            <div class="form-check w-100 mb-0">
                                                <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="cod" {{ old('payment_method', $defaultMethod) == 'cod' ? 'checked' : '' }} onchange="togglePayment('cod')">
                                                <label class="form-check-label w-100 ms-2" for="payment_cod">
                                                    <i class="fas fa-money-bill-wave me-3 text-primary-custom fs-4"></i> {{ __('Cash on Delivery') }}
                                                </label>
                                            </div>
                                        </div>
                                    </h2>
                                    <div id="codCollapse" class="collapse {{ old('payment_method', $defaultMethod) == 'cod' ? 'show' : '' }}">
                                        <div class="accordion-body border-top">{{ __('Pay with cash when your order is delivered to your address.') }}</div>
                                    </div>
                                </div>
                                @endif

                                @if($hasWa)
                                <div class="accordion-item rounded-4 border overflow-hidden mb-3">
                                    <h2 class="accordion-header">
                                        <div class="accordion-button collapsed bg-light fw-bold py-3" style="cursor: pointer;">
                                            <div class="form-check w-100 mb-0">
                                                <input class="form-check-input" type="radio" name="payment_method" id="payment_whatsapp" value="whatsapp" {{ old('payment_method', $defaultMethod) == 'whatsapp' ? 'checked' : '' }} onchange="togglePayment('wa')">
                                                <label class="form-check-label w-100 ms-2" for="payment_whatsapp">
                                                    <i class="fab fa-whatsapp me-3 text-success fs-4"></i> {{ __('Order via WhatsApp') }}
                                                </label>
                                            </div>
                                        </div>
                                    </h2>
                                    <div id="waCollapse" class="collapse {{ old('payment_method', $defaultMethod) == 'whatsapp' ? 'show' : '' }}">
                                        <div class="accordion-body border-top">
                                            {{ __('Place your order here first. You will then be redirected to WhatsApp to send your order details directly to us for faster processing.') }}
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if(!$hasCard && !$hasCod && !$hasWa)
                                    <div class="alert alert-warning">
                                        {{ __('No payment methods are currently enabled. Please contact support.') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-5">
                        <div class="card border-0 shadow rounded-4 sticky-top" style="top: 120px; background-color: var(--background);">
                            <div class="card-body p-4 p-lg-5">
                                <h4 class="playfair mb-4">{{ __('Your Order') }}</h4>
                                
                                <div class="order-items-scroll mb-4" style="max-height: 300px; overflow-y: auto;">
                                    @foreach($cartItems as $item)
                                        @php
                                            $price = $item->product->sale_price ?: $item->product->price;
                                        @endphp
                                        <div class="d-flex gap-3 mb-3 border-bottom pb-3 border-dark border-opacity-10 me-2">
                                            <div class="position-relative">
                                                <img src="{{ asset($item->product->main_image) }}" class="rounded object-fit-cover shadow-sm" style="width: 60px; height: 60px;">
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary-custom">{{ $item->quantity }}</span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-bold mb-1 small">{{ $item->product->name }}</h6>
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
                                <div class="d-flex justify-content-between mb-4 text-muted pb-4 border-bottom border-dark border-opacity-10">
                                    <span>{{ __('Taxes') }}</span>
                                    <span class="fw-bold text-dark">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($tax, 2) }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-5 align-items-center">
                                    <h5 class="fw-bold mb-0">{{ __('Total') }}</h5>
                                    <h2 class="fw-bold text-primary-custom mb-0">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($total, 2) }}</h2>
                                </div>

                                <button type="submit" class="btn btn-primary-custom btn-lg w-100 rounded-pill py-3 fw-bold shadow">
                                    {{ __('Place Order Securely') }} <i class="fas fa-lock ms-2"></i>
                                </button>
                                
                                <p class="text-center text-muted small mt-4 mb-0 opacity-75">
                                    <i class="fas fa-shield-alt me-1"></i> {{ __('Your data is processed securely.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        function togglePayment(mode) {
            const cc = document.getElementById('ccCollapse');
            const cod = document.getElementById('codCollapse');
            const wa = document.getElementById('waCollapse');
            
            if(cc) cc.classList.remove('show');
            if(cod) cod.classList.remove('show');
            if(wa) wa.classList.remove('show');

            if(mode === 'cc' && cc) cc.classList.add('show');
            if(mode === 'cod' && cod) cod.classList.add('show');
            if(mode === 'wa' && wa) wa.classList.add('show');
        }
    </script>
@endsection
