@extends('layouts.app')

@section('content')
    <section class="py-5 bg-white min-vh-100 d-flex align-items-center mt-5">
        <div class="container py-5 text-center">
            <div class="mx-auto bg-success text-white rounded-circle d-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                <i class="fas fa-check fs-1"></i>
            </div>
            <h1 class="playfair display-4 mb-3">{{ __('Order Successful!') }}</h1>
            <p class="lead text-muted mb-4 col-md-8 mx-auto">{{ __("Thank you for your purchase. We've received your order and are getting it ready to ship.") }}</p>
            
            @if($order && $order->payment_method === 'whatsapp')
                @php
                    $waNumber = preg_replace('/[^0-9]/', '', $globalSettings['whatsapp_number'] ?? '');
                    $msg = "✨ *NEW ORDER PLACED* ✨\n";
                    $msg .= "┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈\n\n";
                    $msg .= "🏷️ *Order ID:* #{$order->order_number}\n";
                    $msg .= "👤 *Customer:* {$order->shipping_name}\n";
                    $msg .= "📞 *Phone:* " . ($order->shipping_phone ?? 'N/A') . "\n";
                    $msg .= "🏠 *Address:* {$order->shipping_address}, {$order->shipping_city}, {$order->shipping_state}\n";
                    if($order->notes) $msg .= "📝 *Notes:* {$order->notes}\n";
                    
                    $msg .= "\n📦 *ITEMS:*\n";
                    foreach($order->items as $item) {
                        $msg .= "▪ " . ($item->product->name ?? 'Product') . " x {$item->quantity} (" . ($globalSettings['currency_symbol'] ?? '$') . " " . number_format($item->price * $item->quantity, 2) . ")\n";
                    }
                    
                    $msg .= "\n💰 *TOTAL AMOUNT:* " . ($globalSettings['currency_symbol'] ?? '$') . " " . number_format($order->total, 2) . "\n";
                    $msg .= "┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈\n\n";
                    $msg .= "🙏 *Thank you for choosing FurniCraft!* \n";
                    $msg .= "_Please confirm my order. Thank you!_";
                    
                    $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode($msg);
                @endphp
                
                <div class="card border-0 shadow-sm rounded-4 mb-5 mx-auto col-md-6" style="background-color: #e7fbd3;">
                    <div class="card-body p-4 text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <i class="fab fa-whatsapp fs-1 text-success me-3"></i>
                            <h5 class="fw-bold mb-0">{{ __('Almost Done!') }}</h5>
                        </div>
                        <p class="mb-4">{{ __('To complete your order, please send your order details to us via WhatsApp. Click the button below:') }}</p>
                        <a href="{{ $waUrl }}" target="_blank" class="btn btn-success btn-lg rounded-pill px-5 fw-bold shadow-sm py-3 w-100">
                            {{ __('Send Order to WhatsApp') }} <i class="fas fa-paper-plane ms-2"></i>
                        </a>
                        <p class="small text-muted mt-3 mb-0">{{ __('This will open WhatsApp and pre-fill your order details.') }}</p>
                    </div>
                </div>

                <script>
                    // Small delay then pulse the button or auto-redirect if preferred
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(() => {
                            const btn = document.querySelector('.btn-success');
                            if(btn) btn.classList.add('pulse-animation');
                        }, 1000);
                    });
                </script>
                <style>
                    @keyframes pulse-btn {
                        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.4); }
                        70% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(25, 135, 84, 0); }
                        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(25, 135, 84, 0); }
                    }
                    .pulse-animation {
                        animation: pulse-btn 2s infinite;
                    }
                </style>
            @endif
            
            @if($order)
            <div class="card bg-light border-0 col-md-6 mx-auto mb-5 rounded-4 shadow-sm">
                <div class="card-body p-4 text-start">
                    <h5 class="fw-bold mb-3 border-bottom pb-3">{{ __('Order Details') }}</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('Order Number:') }}</span>
                        <span class="fw-bold">#{{ $order->order_number }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('Date:') }}</span>
                        <span class="fw-bold">{{ $order->created_at->format('F j, Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('Payment Method:') }}</span>
                        <span class="fw-bold text-uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">{{ __('Total Amount:') }}</span>
                        <span class="fw-bold text-primary-custom">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
            @endif

            <a href="{{ route('shop.index') }}" class="btn btn-primary-custom btn-lg rounded-pill px-5 shadow">{{ __('Continue Shopping') }}</a>
        </div>
    </section>
@endsection
