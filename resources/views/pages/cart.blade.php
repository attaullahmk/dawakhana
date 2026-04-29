@extends('layouts.app')

@section('content')
    <!-- Page Header (Hidden on Mobile) -->
    <div class="page-header text-center d-none d-md-block" style="background-color: var(--primary); padding: 80px 0 40px; margin-top: 50px; color: var(--white);">
        <div class="container pt-5">
            <h1 class="playfair display-4 mb-2">{{ __('Shopping Cart') }}</h1>
        </div>
    </div>

    <section class="py-5 bg-white min-vh-100">
        <div class="container py-4">
            @if($cartItems->count() > 0)
            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <!-- Desktop Table View (Hidden on Mobile) -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table align-middle border text-center">
                            <thead class="bg-light text-muted small text-uppercase">
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
                                                <img src="{{ asset($item->product->main_image) }}" loading="lazy" class="rounded object-fit-cover shadow-sm" alt="{{ $item->product->name }}" style="width: 80px; height: 80px;">
                                                <div>
                                                    <h6 class="fw-bold mb-1"><a href="{{ route('product.show', $item->product->slug) }}" class="text-dark text-decoration-none">{{ $item->product->name }}</a></h6>
                                                    <small class="text-muted">{{ $item->product->category->name ?? __('Uncategorized') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-muted">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($price, 2) }}</td>
                                        <td>
                                            <div class="input-group border rounded-pill overflow-hidden mx-auto" style="width: 120px;">
                                                <button class="btn btn-light border-0 px-3 update-qty-btn" data-action="minus" type="button">-</button>
                                                <input type="text" class="form-control border-0 text-center bg-white shadow-none qty-input" value="{{ $item->quantity }}" data-max="{{ $item->product->stock_quantity }}" readonly>
                                                <button class="btn btn-light border-0 px-3 update-qty-btn" data-action="plus" type="button">+</button>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-primary-custom fs-5 row-subtotal">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($itemSubtotal, 2) }}</td>
                                        <td>
                                            <button class="btn btn-link text-danger border-0 p-0 remove-cart-btn"><i class="fas fa-times fs-5"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View (Visible on Mobile Only) -->
                    <div class="d-md-none">
                        @foreach($cartItems as $item)
                            @php
                                $price = $item->product->sale_price ?: $item->product->price;
                                $itemSubtotal = $price * $item->quantity;
                            @endphp
                            <div class="card border rounded-4 mb-3 shadow-sm overflow-hidden" data-cart-id="{{ $item->id }}" data-price="{{ $price }}">
                                <div class="card-body p-3">
                                    <div class="d-flex gap-3 mb-3">
                                        <img src="{{ asset($item->product->main_image) }}" loading="lazy" class="rounded object-fit-cover shadow-sm" alt="{{ $item->product->name }}" style="width: 80px; height: 80px;">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="fw-bold mb-1"><a href="{{ route('product.show', $item->product->slug) }}" class="text-dark text-decoration-none">{{ $item->product->name }}</a></h6>
                                                    <small class="text-muted d-block mb-2">{{ $item->product->category->name ?? __('Uncategorized') }}</small>
                                                </div>
                                                <button class="btn btn-link text-danger border-0 p-0 remove-cart-btn"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                            <div class="fw-bold text-muted small">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($price, 2) }} {{ __('each') }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded-3">
                                        <div class="input-group border rounded-pill overflow-hidden bg-white" style="width: 110px;">
                                            <button class="btn btn-white border-0 px-2 update-qty-btn" data-action="minus" type="button">-</button>
                                            <input type="text" class="form-control border-0 text-center bg-white shadow-none qty-input px-1" value="{{ $item->quantity }}" data-max="{{ $item->product->stock_quantity }}" readonly style="font-size: 0.9rem;">
                                            <button class="btn btn-white border-0 px-2 update-qty-btn" data-action="plus" type="button">+</button>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted d-block" style="font-size: 0.7rem;">{{ __('SUBTOTAL') }}</small>
                                            <span class="fw-bold text-primary-custom row-subtotal">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($itemSubtotal, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-pill px-4"><i class="fas fa-arrow-left me-2"></i> {{ __('Continue Shopping') }}</a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4" style="background-color: var(--background);">
                        <div class="card-body p-4 p-lg-5">
                            <h4 class="playfair mb-4">{{ __('Order Summary') }}</h4>
                            
                            <div class="d-flex justify-content-between mb-3 text-muted">
                                <span>{{ __('Subtotal') }}</span>
                                <span class="fw-bold text-dark" id="summary-subtotal">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($subtotal, 2) }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-3 text-success {{ $discount > 0 ? '' : 'd-none' }}" id="summary-discount-row">
                                <span>{{ __('Discount') }} <small id="applied-coupon-code" class="text-muted ms-1">{{ $coupon ? '('.$coupon->code.')' : '' }}</small></span>
                                <span class="fw-bold" id="summary-discount">-{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($discount, 2) }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3 text-muted">
                                <span>{{ __('Shipping Estimate') }}</span>
                                <span class="fw-bold text-dark" id="summary-shipping">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($shipping, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4 text-muted pb-4 border-bottom border-dark border-opacity-10">
                                <span>{{ __('Estimated Tax') }}</span>
                                <span class="fw-bold text-dark" id="summary-tax">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($tax, 2) }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-4 align-items-center">
                                <h5 class="fw-bold mb-0">{{ __('Total') }}</h5>
                                <h3 class="fw-bold text-primary-custom mb-0" id="summary-total">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($total, 2) }}</h3>
                            </div>

                            <div id="coupon-alert" class="alert alert-danger d-none small py-2 mb-3"></div>

                            <form class="mb-4" id="coupon-form" >
                                @if($coupon)
                                    <div class="d-grid">
                                        <button class="btn btn-outline-danger rounded-pill px-4" type="button" id="remove-coupon-btn">Remove Coupon</button>
                                    </div>
                                @else
                                    <div class="input-group">
                                        <input type="text" name="code" id="coupon-code-input" class="form-control border-secondary shadow-none rounded-start-pill py-2" placeholder="{{ __('Coupon Code') }}">
                                        <button class="btn btn-secondary-custom rounded-end-pill px-4" type="submit">{{ __('Apply') }}</button>
                                    </div>
                                @endif
                            </form>
                            
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary-custom btn-lg w-100 rounded-pill py-3 fw-bold mb-3 shadow">
                                {{ __('Proceed to Checkout') }}
                            </a>
                            
                            <div class="text-center mt-4">
                                <p class="text-muted mb-2 small text-uppercase fw-bold">{{ __('We Accept') }}</p>
                                <div class="d-flex justify-content-center gap-2 fs-3 text-muted opacity-75">
                                    <i class="fab fa-cc-visa"></i>
                                    <i class="fab fa-cc-mastercard"></i>
                                    <i class="fab fa-cc-amex"></i>
                                    <i class="fab fa-cc-paypal"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-5 my-5">
                <i class="fas fa-shopping-basket fs-1 text-muted mb-3 opacity-50" style="font-size: 4rem !important;"></i>
                <h3 class="playfair mb-3">{{ __('Your cart is currently empty') }}</h3>
                <p class="text-muted mb-4">{{ __('Before proceed to checkout you must add some products to your shopping cart.') }}</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary-custom btn-lg rounded-pill px-5 shadow">{{ __('Return To Shop') }}</a>
            </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';
    
    function applyDataToView(data) {
        if(data.subtotal === 0) {
            window.location.reload();
            return;
        }

        // Update mathematics from backend
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
            
            if (this.getAttribute('data-action') === 'plus') {
                if(qty < max) qty++;
            } else {
                if(qty > 1) qty--;
            }
            
            input.value = qty;
            
            // Recalculate physical row
            const price = parseFloat(row.getAttribute('data-price'));
            row.querySelector('.row-subtotal').innerText = window.currencySymbol + (price * qty).toFixed(2);

            // Background update
            fetch('/cart/update', {
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
                if(data.error) { alert(data.error); }
                else { applyDataToView(data); }
            })
            .catch(err => console.error("Update error: ", err));
        });
    });

    document.querySelectorAll('.remove-cart-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if(!confirm("Are you sure you want to remove this item?")) return;
            
            const row = this.closest('[data-cart-id]');
            const cartId = row.getAttribute('data-cart-id');
            
            fetch('/cart/remove', {
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
                }
            })
            .catch(err => console.error("Remove error: ", err));
        });
    });

    const couponForm = document.getElementById('coupon-form');
    if(couponForm) {
        couponForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const alertBox = document.getElementById('coupon-alert');
            const codeInput = document.getElementById('coupon-code-input');
            if(!codeInput || !codeInput.value.trim()) return;

            fetch('/cart/coupon/apply', {
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
                } else {
                    window.location.reload(); // Reload securely to restructure UI blocks
                }
            })
            .catch(err => console.error("Coupon error: ", err));
        });
    }

    const removeCouponBtn = document.getElementById('remove-coupon-btn');
    if(removeCouponBtn) {
        removeCouponBtn.addEventListener('click', function(e) {
            fetch('/cart/coupon/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                window.location.reload();
            });
        });
    }
});
</script>
@endpush
