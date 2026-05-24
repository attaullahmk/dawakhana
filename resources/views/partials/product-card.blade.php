@once
<style>
.premium-product-card {
    --p-green: #17382b;
    --p-green-light: #2d6a4f;
    --p-gold: #c8a165;
    --p-gold-light: #e2c08d;
    --p-ink: #1f2d26;
    --p-muted: #6f7d73;
    --p-line: rgba(26, 60, 46, 0.12);
    position: relative;
    height: 100%;
    overflow: hidden;
    border: 1px solid rgba(26, 60, 46, 0.1) !important;
    border-radius: 8px !important;
    background: linear-gradient(180deg, #fff 0%, #fff 62%, #fbf8f1 100%) !important;
    box-shadow: 0 12px 30px rgba(26, 60, 46, 0.08) !important;
    transition: transform 0.32s ease, box-shadow 0.32s ease, border-color 0.32s ease;
    isolation: isolate;
}

.premium-product-card::before {
    content: '';
    position: absolute;
    inset: 0;
    z-index: 8;
    pointer-events: none;
    border-radius: 8px;
    border: 1px solid transparent;
    transition: border-color 0.28s ease, box-shadow 0.28s ease;
}

.premium-product-card::after {
    content: '';
    position: absolute;
    left: 18px;
    right: 18px;
    bottom: 0;
    z-index: 7;
    height: 4px;
    border-radius: 8px 8px 0 0;
    background: linear-gradient(90deg, var(--p-gold), var(--p-green-light));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.32s ease;
}

.premium-product-card:hover {
    transform: translateY(-10px);
    border-color: rgba(200, 161, 101, 0.46) !important;
    box-shadow: 0 26px 56px rgba(26, 60, 46, 0.16) !important;
}

.premium-product-card:hover::before {
    border-color: rgba(200, 161, 101, 0.5);
    box-shadow: inset 0 0 0 1px rgba(200, 161, 101, 0.12);
}

.premium-product-card:hover::after {
    transform: scaleX(1);
}

.premium-product-media {
    position: relative;
    overflow: hidden;
    background: #edf4ef;
}

.premium-product-media::after {
    content: '';
    position: absolute;
    inset: 0;
    z-index: 2;
    pointer-events: none;
    background:
        linear-gradient(180deg, rgba(23,56,43,0.02) 35%, rgba(23,56,43,0.18) 100%),
        radial-gradient(circle at top right, rgba(200,161,101,0.18), transparent 34%);
    opacity: 0.72;
    transition: opacity 0.32s ease;
}

.premium-product-card:hover .premium-product-media::after {
    opacity: 1;
}

.premium-product-img {
    width: 100%;
    height: 238px !important;
    object-fit: cover;
    transition: transform 0.52s ease, filter 0.52s ease !important;
}

.premium-product-card:hover .premium-product-img {
    transform: scale(1.075) rotate(0.5deg);
    filter: saturate(1.08) contrast(1.04);
}

.premium-product-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    z-index: 10;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    min-height: 30px;
    border-radius: 50px;
    padding: 7px 12px;
    color: #fff;
    font-size: 0.68rem;
    font-weight: 900;
    letter-spacing: 1px;
    text-transform: uppercase;
    box-shadow: 0 8px 18px rgba(0,0,0,0.12);
}

.premium-product-badge.is-sale {
    background: linear-gradient(135deg, #c84242, #e75d5d);
}

.premium-product-badge.is-new {
    background: linear-gradient(135deg, var(--p-green), var(--p-green-light));
}

.premium-product-wishlist {
    position: absolute;
    top: 14px;
    right: 14px;
    z-index: 10;
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255,255,255,0.65) !important;
    border-radius: 50% !important;
    color: var(--p-green) !important;
    background: rgba(255,255,255,0.9) !important;
    box-shadow: 0 10px 24px rgba(26,60,46,0.14) !important;
    backdrop-filter: blur(12px);
    transition: transform 0.25s ease, background 0.25s ease, color 0.25s ease;
}

.premium-product-wishlist:hover,
.premium-product-wishlist:focus {
    transform: translateY(-2px) scale(1.06);
    color: #fff !important;
    background: var(--p-green) !important;
}

.premium-product-stock {
    position: absolute;
    inset: 0;
    z-index: 9;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.82);
    backdrop-filter: blur(4px);
}

.premium-product-stock span {
    border-radius: 50px;
    color: #fff;
    background: #c84242;
    padding: 10px 18px;
    font-weight: 900;
    box-shadow: 0 12px 26px rgba(200,66,66,0.22);
}

.premium-product-quick {
    position: absolute;
    left: 14px;
    right: 14px;
    bottom: 14px;
    z-index: 10;
    display: flex;
    gap: 8px;
    opacity: 0;
    transform: translateY(12px);
    transition: opacity 0.28s ease, transform 0.28s ease;
}

.premium-product-card:hover .premium-product-quick {
    opacity: 1;
    transform: translateY(0);
}

.premium-product-quick a {
    flex: 1;
    min-height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border-radius: 50px;
    color: var(--p-green);
    background: rgba(255,255,255,0.92);
    font-size: 0.78rem;
    font-weight: 900;
    text-decoration: none;
    backdrop-filter: blur(12px);
    transition: transform 0.24s ease, background 0.24s ease, color 0.24s ease;
}

.premium-product-quick a:hover {
    color: #fff;
    background: var(--p-green);
    transform: translateY(-2px);
}

.premium-product-carousel .carousel-control-prev,
.premium-product-carousel .carousel-control-next {
    z-index: 11;
    width: 42px;
    opacity: 0;
    transition: opacity 0.25s ease, transform 0.25s ease;
}

.premium-product-card:hover .premium-product-carousel .carousel-control-prev,
.premium-product-card:hover .premium-product-carousel .carousel-control-next {
    opacity: 1;
}

.premium-product-carousel .carousel-control-prev {
    transform: translateX(-8px);
}

.premium-product-carousel .carousel-control-next {
    transform: translateX(8px);
}

.premium-product-card:hover .premium-product-carousel .carousel-control-prev,
.premium-product-card:hover .premium-product-carousel .carousel-control-next {
    transform: translateX(0);
}

.premium-product-carousel .carousel-control-prev-icon,
.premium-product-carousel .carousel-control-next-icon {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background-color: rgba(23,56,43,0.82);
    background-size: 46%;
    box-shadow: 0 10px 22px rgba(0,0,0,0.18);
}

.premium-product-body {
    position: relative;
    z-index: 6;
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 18px 18px 14px !important;
}

.premium-product-meta {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}

.premium-product-title {
    color: var(--p-ink);
    font-size: 1.05rem;
    line-height: 1.28;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.premium-product-category {
    flex: 0 0 auto;
    max-width: 45%;
    border: 1px solid rgba(200,161,101,0.26);
    border-radius: 50px;
    color: var(--p-green);
    background: rgba(200,161,101,0.12);
    padding: 5px 9px;
    font-size: 0.62rem;
    font-weight: 900;
    letter-spacing: 0.7px;
    text-transform: uppercase;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.premium-product-desc {
    min-height: 2.75rem;
    color: var(--p-muted);
    font-size: 0.86rem;
    line-height: 1.55;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.premium-product-trust {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 8px;
}

.premium-product-chip {
    min-height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    border: 1px solid rgba(26,60,46,0.08);
    border-radius: 8px;
    color: var(--p-green);
    background: rgba(248,245,240,0.78);
    font-size: 0.7rem;
    font-weight: 900;
    line-height: 1.1;
    text-align: center;
    transition: transform 0.24s ease, border-color 0.24s ease, background 0.24s ease, color 0.24s ease;
}

.premium-product-chip i {
    color: var(--p-gold);
    font-size: 0.74rem;
    transition: transform 0.24s ease, color 0.24s ease;
}

.premium-product-card:hover .premium-product-chip {
    border-color: rgba(200,161,101,0.28);
    background: rgba(200,161,101,0.12);
}

.premium-product-chip:hover {
    transform: translateY(-2px);
    color: var(--p-gold-light);
    border-color: rgba(226,192,141,0.55);
    background: var(--p-green);
}

.premium-product-chip:hover i {
    color: var(--p-gold-light);
    transform: scale(1.12);
}

.premium-product-rating {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    border-top: 1px solid rgba(26,60,46,0.08);
    border-bottom: 1px solid rgba(26,60,46,0.08);
    padding: 11px 0;
}

.premium-product-stars {
    color: #d6a33d;
    font-size: 0.78rem;
    white-space: nowrap;
}

.premium-product-reviews {
    color: var(--p-muted);
    font-size: 0.78rem;
    font-weight: 700;
}

.premium-product-price-row {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    gap: 10px;
}

.premium-product-price {
    color: var(--p-green);
    font-size: 1.22rem;
    font-weight: 900;
}

.premium-product-price.is-sale {
    color: #c84242;
}

.premium-product-old-price {
    color: var(--p-muted);
    font-size: 0.82rem;
    text-decoration: line-through;
}

.premium-product-save {
    color: var(--p-green);
    background: rgba(45,106,79,0.1);
    border-radius: 50px;
    padding: 5px 9px;
    font-size: 0.68rem;
    font-weight: 900;
    white-space: nowrap;
}

.premium-product-footer {
    position: relative;
    z-index: 6;
    padding: 0 18px 18px !important;
    border: 0 !important;
    background: transparent !important;
}

.premium-product-cart {
    width: 100%;
    min-height: 46px;
    border: 0 !important;
    border-radius: 8px !important;
    color: #fff !important;
    background: linear-gradient(135deg, var(--p-green), var(--p-green-light)) !important;
    font-weight: 900 !important;
    box-shadow: 0 12px 26px rgba(26,60,46,0.18) !important;
    transition: transform 0.24s ease, box-shadow 0.24s ease, filter 0.24s ease;
}

.premium-product-cart:hover,
.premium-product-cart:focus {
    transform: translateY(-2px);
    box-shadow: 0 18px 34px rgba(26,60,46,0.24) !important;
    filter: brightness(1.04);
}

.premium-product-cart.disabled,
.premium-product-cart:disabled {
    opacity: 0.62;
    pointer-events: none;
}

.premium-product-cart i,
.premium-product-quick i {
    transition: transform 0.24s ease;
}

.premium-product-cart:hover i {
    transform: translateX(3px);
}

@media (max-width: 767.98px) {
    .premium-product-img {
        height: 215px !important;
    }

    .premium-product-quick {
        opacity: 1;
        transform: none;
    }

    .premium-product-carousel .carousel-control-prev,
    .premium-product-carousel .carousel-control-next {
        opacity: 1;
    }
}
</style>
@endonce

@php
    $inWishlist = auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists();
    $avgRating = $product->reviews->avg('rating') ?? 0;
    $reviewCount = $product->reviews->count();
    $carouselId = 'carouselProduct' . $product->id . '-' . uniqid();
    $hasSale = $product->sale_price && $product->sale_price < $product->price;
    $isNew = !$hasSale && (now()->diffInDays($product->created_at)) < 30;
    $discountPercent = $hasSale && $product->price > 0
        ? round((($product->price - $product->sale_price) / $product->price) * 100)
        : null;
    $currency = $globalSettings['currency_symbol'] ?? '$';
    $categoryName = $product->category->name ?? __('Uncategorized');
    $hasExtraImages = $product->images->count() > 0;
@endphp

<div class="card premium-product-card h-100">
    @if($hasSale)
        <span class="premium-product-badge is-sale">
            <i class="fas fa-tag"></i>
            {{ __('Sale') }} @if($discountPercent) {{ $discountPercent }}% @endif
        </span>
    @elseif($isNew)
        <span class="premium-product-badge is-new">
            <i class="fas fa-leaf"></i>
            {{ __('New') }}
        </span>
    @endif

    @if($product->stock_quantity <= 0)
        <div class="premium-product-stock">
            <span>{{ __('Out of Stock') }}</span>
        </div>
    @endif

    <button type="button"
        class="premium-product-wishlist toggle-wishlist"
        data-product-id="{{ $product->id }}"
        aria-label="{{ $inWishlist ? __('Remove from wishlist') : __('Add to wishlist') }}">
        <i class="{{ $inWishlist ? 'fas fa-heart text-danger' : 'far fa-heart' }}"></i>
    </button>

    <div class="premium-product-media">
        <div id="{{ $carouselId }}" class="carousel slide premium-product-carousel" data-bs-ride="false" data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="{{ route('product.show', $product->slug) }}">
                        <img src="{{ $product->main_image }}"
                            loading="lazy"
                            class="card-img-top premium-product-img"
                            alt="{{ $product->name }}">
                    </a>
                </div>
                @if($hasExtraImages)
                    @foreach($product->images as $extraImg)
                        <div class="carousel-item">
                            <a href="{{ route('product.show', $product->slug) }}">
                                <img src="{{ $extraImg->image_path }}"
                                    loading="lazy"
                                    class="card-img-top premium-product-img"
                                    alt="{{ $product->name }}">
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>

            @if($hasExtraImages)
                <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev" aria-label="{{ __('Previous image') }}">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next" aria-label="{{ __('Next image') }}">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            @endif
        </div>

        <div class="premium-product-quick">
            <a href="{{ route('product.show', $product->slug) }}" aria-label="{{ __('View details for') }} {{ $product->name }}">
                <i class="fas fa-eye"></i>{{ __('View Details') }}
            </a>
        </div>
    </div>

    <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none" aria-label="{{ __('View') }} {{ $product->name }} {{ __('details') }}">
        <div class="card-body premium-product-body">
            <div class="premium-product-meta">
                <h5 class="premium-product-title playfair fw-bold">{{ $product->name }}</h5>
                <span class="premium-product-category" title="{{ $categoryName }}">{{ $categoryName }}</span>
            </div>

            <p class="premium-product-desc">
                {{ $product->short_description ?: __('Explore this trusted herbal wellness product for daily natural care.') }}
            </p>

            <div class="premium-product-trust" aria-label="{{ __('Product highlights') }}">
                <span class="premium-product-chip">
                    <i class="fas fa-check-circle"></i>
                    {{ $product->stock_quantity > 0 ? __('In Stock') : __('Limited') }}
                </span>
                <span class="premium-product-chip">
                    <i class="fas fa-seedling"></i>
                    {{ __('Herbal Care') }}
                </span>
            </div>

            <div class="premium-product-rating">
                <div class="premium-product-stars" aria-label="{{ __('Average rating') }} {{ number_format($avgRating, 1) }}">
                    @php $fullStars = floor($avgRating); @endphp
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $fullStars)
                            <i class="fas fa-star"></i>
                        @elseif($i == ceil($avgRating) && $avgRating > $fullStars)
                            <i class="fas fa-star-half-alt"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <span class="premium-product-reviews">{{ $reviewCount }} {{ __('Reviews') }}</span>
            </div>

            <div class="premium-product-price-row">
                <div>
                    @if($hasSale)
                        <span class="premium-product-price is-sale">{{ $currency }} {{ number_format($product->sale_price, 2) }}</span>
                        <span class="premium-product-old-price ms-1">{{ $currency }} {{ number_format($product->price, 2) }}</span>
                    @else
                        <span class="premium-product-price">{{ $currency }} {{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                @if($hasSale && $discountPercent)
                    <span class="premium-product-save">{{ __('Save') }} {{ $discountPercent }}%</span>
                @endif
            </div>
        </div>
    </a>

    <div class="card-footer premium-product-footer">
        <button type="button"
            class="btn add-to-cart-btn p-card-btn premium-product-cart {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}"
            data-product-id="{{ $product->id }}"
            {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
            <i class="fas fa-shopping-cart me-2"></i>
            {{ $product->stock_quantity <= 0 ? __('Unavailable') : __('Add to Cart') }}
        </button>
    </div>
</div>
