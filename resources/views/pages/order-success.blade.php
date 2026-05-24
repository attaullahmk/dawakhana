@extends('layouts.app')

@push('styles')
<style>
:root {
    --success-green: #17382b;
    --success-green-light: #2d6a4f;
    --success-gold: #c8a165;
    --success-gold-light: #e2c08d;
    --success-ink: #1f2d26;
    --success-muted: #6f7d73;
    --success-line: rgba(26, 60, 46, 0.12);
    --success-soft: #f8f5f0;
    --success-shadow: 0 22px 54px rgba(26, 60, 46, 0.13);
}

.success-page {
    min-height: 100vh;
    overflow: hidden;
    background:
        radial-gradient(circle at 8% 12%, rgba(45, 106, 79, 0.1), transparent 28%),
        radial-gradient(circle at 92% 18%, rgba(200, 161, 101, 0.13), transparent 24%),
        linear-gradient(180deg, #fff 0%, var(--success-soft) 100%);
}

.success-hero {
    position: relative;
    min-height: 380px;
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

.success-hero::after {
    content: '';
    position: absolute;
    inset: auto 0 0;
    height: 98px;
    background: linear-gradient(180deg, transparent, rgba(248, 245, 240, 0.98));
}

.success-hero-content {
    position: relative;
    z-index: 2;
    max-width: 780px;
    padding: 98px 0 128px;
}

.success-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: 1px solid rgba(226, 192, 141, 0.42);
    border-radius: 50px;
    background: rgba(200, 161, 101, 0.14);
    color: var(--success-gold-light);
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 2.2px;
    text-transform: uppercase;
    margin-bottom: 18px;
}

.success-hero h1,
.success-title {
    font-family: 'Playfair Display', serif;
    font-weight: 800;
    letter-spacing: 0;
}

.success-hero p {
    max-width: 680px;
    color: rgba(255, 255, 255, 0.84);
    line-height: 1.8;
}

.success-shell {
    position: relative;
    z-index: 5;
    margin-top: -76px;
    padding-bottom: 82px;
}

.success-panel,
.success-card {
    border: 1px solid var(--success-line);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.94);
    box-shadow: 0 16px 36px rgba(26, 60, 46, 0.09);
}

.success-panel {
    overflow: hidden;
}

.success-main {
    padding: clamp(28px, 5vw, 48px);
}

.success-icon {
    width: 92px;
    height: 92px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #fff;
    background: linear-gradient(135deg, var(--success-green), var(--success-green-light));
    box-shadow: 0 18px 34px rgba(26, 60, 46, 0.22);
    margin-bottom: 22px;
    animation: successPulse 2.2s ease-in-out infinite;
}

.success-title {
    position: relative;
    display: inline-block;
    color: #123524;
    background: linear-gradient(135deg, #0f3d2e 0%, #2f7d4f 48%, #c7962e 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    padding-bottom: 12px;
    margin-bottom: 18px;
    text-shadow: 0 12px 28px rgba(27, 67, 50, 0.12);
}

.success-title::after {
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

.success-steps {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
    margin-top: 28px;
}

.success-step {
    border: 1px solid rgba(200, 161, 101, 0.24);
    border-radius: 8px;
    color: var(--success-green);
    background: rgba(200, 161, 101, 0.1);
    padding: 14px;
}

.success-step i {
    color: var(--success-gold);
}

.whatsapp-card {
    border: 1px solid rgba(37, 211, 102, 0.28);
    border-radius: 8px;
    background:
        linear-gradient(145deg, rgba(232, 255, 239, 0.96), rgba(255, 255, 255, 0.96));
    box-shadow: 0 18px 38px rgba(37, 211, 102, 0.12);
}

.whatsapp-btn {
    min-height: 56px;
    border: 0;
    border-radius: 8px;
    color: #fff;
    background: linear-gradient(135deg, #159947, #25d366);
    font-weight: 900;
    box-shadow: 0 16px 34px rgba(37, 211, 102, 0.22);
}

.whatsapp-btn:hover {
    color: #fff;
    transform: translateY(-2px);
}

.pulse-animation {
    animation: whatsappPulse 2s infinite;
}

.success-card {
    overflow: hidden;
}

.success-card::before {
    content: '';
    display: block;
    height: 5px;
    background: linear-gradient(90deg, var(--success-gold), var(--success-green-light));
}

.detail-row {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    color: var(--success-muted);
    border-bottom: 1px solid rgba(26, 60, 46, 0.08);
    padding: 12px 0;
}

.detail-row:last-child {
    border-bottom: 0;
}

.detail-row strong {
    color: var(--success-ink);
    text-align: right;
}

.success-items {
    max-height: 330px;
    overflow: auto;
}

.success-item {
    display: flex;
    justify-content: space-between;
    gap: 14px;
    border-bottom: 1px solid rgba(26, 60, 46, 0.08);
    padding: 13px 0;
}

.success-item:last-child {
    border-bottom: 0;
}

.success-actions {
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 28px;
}

.success-btn-primary,
.success-btn-outline {
    min-height: 54px;
    border-radius: 8px;
    font-weight: 900;
    padding: 13px 22px;
}

.success-btn-primary {
    border: 0;
    color: #fff;
    background: linear-gradient(135deg, var(--success-green), var(--success-green-light));
    box-shadow: 0 16px 34px rgba(26, 60, 46, 0.22);
}

.success-btn-outline {
    border: 1px solid rgba(26, 60, 46, 0.18);
    color: var(--success-green);
    background: #fff;
}

.success-btn-primary:hover,
.success-btn-outline:hover {
    transform: translateY(-2px);
}

@keyframes successPulse {
    0%, 100% { transform: scale(1); box-shadow: 0 18px 34px rgba(26, 60, 46, 0.22); }
    50% { transform: scale(1.04); box-shadow: 0 24px 44px rgba(26, 60, 46, 0.28); }
}

@keyframes whatsappPulse {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.34); }
    70% { transform: scale(1.03); box-shadow: 0 0 0 16px rgba(37, 211, 102, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
}

@media (max-width: 991.98px) {
    .success-hero {
        margin-top: 0;
        min-height: auto;
    }

    .success-hero-content {
        padding: 108px 0 96px;
    }

    .success-shell {
        margin-top: 0;
        padding-top: 42px;
    }
}

@media (max-width: 575.98px) {
    .success-hero h1 {
        font-size: 2.35rem;
    }

    .success-steps {
        grid-template-columns: 1fr;
    }

    .detail-row {
        flex-direction: column;
        gap: 4px;
    }

    .detail-row strong {
        text-align: left;
    }
}
</style>
@endpush

@section('content')
<main class="success-page">
    <section class="success-hero">
        <div class="container">
            <div class="success-hero-content">
                <span class="success-badge">
                    <i class="fas fa-circle-check"></i>{{ __('Order Confirmed') }}
                </span>
                <h1 class="display-4 mb-3">{{ __('Order Successful!') }}</h1>
                <p class="lead mb-0">{{ __("Thank you for choosing Dawakhana. We've received your order and our team is preparing your herbal products with care.") }}</p>
            </div>
        </div>
    </section>

    <section class="success-shell">
        <div class="container">
            <div class="success-panel">
                <div class="success-main text-center">
                    <span class="success-icon">
                        <i class="fas fa-check fa-2x"></i>
                    </span>
                    <h2 class="success-title display-5">{{ __('Your order is in safe hands') }}</h2>
                    <p class="text-muted lead mb-0 col-lg-8 mx-auto">{{ __('We will review your order details, prepare your items, and contact you if confirmation is needed.') }}</p>

                    <div class="success-steps">
                        <div class="success-step">
                            <i class="fas fa-receipt mb-2"></i>
                            <strong class="d-block">{{ __('Order Received') }}</strong>
                            <small>{{ __('Details saved') }}</small>
                        </div>
                        <div class="success-step">
                            <i class="fas fa-box-open mb-2"></i>
                            <strong class="d-block">{{ __('Preparing') }}</strong>
                            <small>{{ __('Products checked') }}</small>
                        </div>
                        <div class="success-step">
                            <i class="fas fa-truck-fast mb-2"></i>
                            <strong class="d-block">{{ __('Delivery') }}</strong>
                            <small>{{ __('Dispatch next') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            @if($order && $order->payment_method === 'whatsapp')
                @php
                    $waNumber = preg_replace('/[^0-9]/', '', $globalSettings['whatsapp_number'] ?? '');
                    $msg = "*NEW DAWAKHANA ORDER*\n";
                    $msg .= "------------------------------\n\n";
                    $msg .= "*Order ID:* #{$order->order_number}\n";
                    $msg .= "*Customer:* {$order->shipping_name}\n";
                    $msg .= "*Phone:* " . ($order->shipping_phone ?? 'N/A') . "\n";
                    $msg .= "*Address:* {$order->shipping_address}, {$order->shipping_city}, {$order->shipping_state}\n";
                    if($order->notes) $msg .= "*Notes:* {$order->notes}\n";

                    $msg .= "\n*ITEMS:*\n";
                    foreach($order->items as $item) {
                        $msg .= "- " . ($item->product->name ?? 'Product') . " x {$item->quantity} (" . ($globalSettings['currency_symbol'] ?? '$') . " " . number_format($item->price * $item->quantity, 2) . ")\n";
                    }

                    $msg .= "\n*TOTAL AMOUNT:* " . ($globalSettings['currency_symbol'] ?? '$') . " " . number_format($order->total, 2) . "\n";
                    $msg .= "------------------------------\n\n";
                    $msg .= "Thank you for choosing Dawakhana.\n";
                    $msg .= "Please confirm my order. Thank you!";

                    $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode($msg);
                @endphp

                <div class="whatsapp-card mt-4 mx-auto col-lg-8">
                    <div class="p-4 p-lg-5 text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <i class="fab fa-whatsapp fs-1 text-success me-3"></i>
                            <h3 class="playfair fw-bold mb-0">{{ __('One more step') }}</h3>
                        </div>
                        <p class="text-muted mb-4">{{ __('Send your order details to us on WhatsApp so our team can confirm and process it faster.') }}</p>
                        <a href="{{ $waUrl }}" target="_blank" class="btn whatsapp-btn btn-lg px-5 py-3 w-100" id="whatsappOrderBtn">
                            {{ __('Send Order to WhatsApp') }} <i class="fas fa-paper-plane ms-2"></i>
                        </a>
                        <p class="small text-muted mt-3 mb-0">{{ __('WhatsApp will open with your order details already filled in.') }}</p>
                    </div>
                </div>
            @endif

            @if($order)
                <div class="row g-4 mt-4">
                    <div class="col-lg-6">
                        <div class="success-card h-100">
                            <div class="p-4 p-lg-5">
                                <h3 class="playfair fw-bold mb-4">{{ __('Order Details') }}</h3>
                                <div class="detail-row">
                                    <span>{{ __('Order Number') }}</span>
                                    <strong>#{{ $order->order_number }}</strong>
                                </div>
                                <div class="detail-row">
                                    <span>{{ __('Date') }}</span>
                                    <strong>{{ $order->created_at->format('F j, Y') }}</strong>
                                </div>
                                <div class="detail-row">
                                    <span>{{ __('Payment Method') }}</span>
                                    <strong class="text-uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</strong>
                                </div>
                                <div class="detail-row">
                                    <span>{{ __('Payment Status') }}</span>
                                    <strong class="text-uppercase">{{ str_replace('_', ' ', $order->payment_status ?? 'pending') }}</strong>
                                </div>
                                <div class="detail-row">
                                    <span>{{ __('Total Amount') }}</span>
                                    <strong style="color: var(--success-green);">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($order->total, 2) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="success-card h-100">
                            <div class="p-4 p-lg-5">
                                <h3 class="playfair fw-bold mb-4">{{ __('Items Ordered') }}</h3>
                                <div class="success-items">
                                    @foreach($order->items as $item)
                                        <div class="success-item">
                                            <div>
                                                <strong class="d-block">{{ $item->product->name ?? __('Product') }}</strong>
                                                <small class="text-muted">{{ __('Quantity') }}: {{ $item->quantity }}</small>
                                            </div>
                                            <strong style="color: var(--success-green);">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($item->price * $item->quantity, 2) }}</strong>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="success-actions">
                <a href="{{ route('shop.index') }}" class="btn success-btn-primary">
                    {{ __('Continue Shopping') }} <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <a href="{{ route('home') }}" class="btn success-btn-outline">
                    <i class="fas fa-home me-2"></i>{{ __('Back to Home') }}
                </a>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function () {
        var btn = document.getElementById('whatsappOrderBtn');
        if(btn) btn.classList.add('pulse-animation');
    }, 1000);
});
</script>
@endpush
