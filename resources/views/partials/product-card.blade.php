@php
    $inWishlist = auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists();
    $avgRating = $product->reviews->avg('rating');
    $reviewCount = $product->reviews->count();
    $carouselId = 'carouselProduct' . $product->id;
@endphp

<div class="card h-100 border-0 card-hover-lift position-relative">
    @if($product->sale_price && $product->sale_price < $product->price)
        <span class="badge bg-danger position-absolute top-0 start-0 m-3 z-3 shadow">{{ __('Sale') }}</span>
    @elseif((now()->diffInDays($product->created_at)) < 30)
        <span class="badge bg-success position-absolute top-0 start-0 m-3 z-3 shadow">{{ __('New') }}</span>
    @endif
    
    @if($product->stock_quantity <= 0)
        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-white bg-opacity-75 z-2" style="border-radius: 0.375rem;">
            <span class="fs-5 fw-bold text-danger">{{ __('Out of Stock') }}</span>
        </div>
    @endif

    <div class="position-absolute top-0 end-0 m-3 z-3">
        <button class="btn btn-light rounded-circle shadow-sm toggle-wishlist" data-product-id="{{ $product->id }}" style="width: 40px; height: 40px;">
            <i class="{{ $inWishlist ? 'fas fa-heart text-danger' : 'far fa-heart text-muted' }}"></i>
        </button>
    </div>

    <!-- Image Carousel -->
    <div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="false" data-bs-interval="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <a href="{{ route('product.show', $product->slug) }}">
                    <img src="{{ $product->main_image }}" loading="lazy" class="card-img-top object-fit-cover" alt="{{ $product->name }}" style="height: 250px;">
                </a>
            </div>
            @if($product->images->count() > 0)
                @foreach($product->images as $extraImg)
                    <div class="carousel-item">
                        <a href="{{ route('product.show', $product->slug) }}">
                            <img src="{{ $extraImg->image_path }}" loading="lazy" class="card-img-top object-fit-cover" alt="{{ $product->name }}" style="height: 250px;">
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
        @if($product->images->count() > 0)
            <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev" style="width: 15%; opacity: 0.8;">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true" style="width: 25px; height: 25px; background-size: 50%;"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next" style="width: 15%; opacity: 0.8;">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true" style="width: 25px; height: 25px; background-size: 50%;"></span>
            </button>
        @endif
    </div>

    <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none text-dark" aria-label="View {{ $product->name }} details">
        <div class="card-body px-3">
            <div class="d-flex justify-content-between align-items-baseline mb-1">
                <h5 class="card-title playfair mb-0 fw-bold" style="font-size: 1.05rem;">{{ $product->name }}</h5>
                <span class="text-uppercase fw-bold" style="color: #D4A853; font-size: 0.65rem; letter-spacing: 0.5px;">{{ $product->category->name ?? 'Uncategorized' }}</span>
            </div>
            
            @if($product->short_description)
                <div style="height: 2.7rem; overflow: hidden; margin-bottom: 1rem;">
                    <p class="text-muted px-2 text-center" 
                       style="font-size: 0.9rem; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 0;">
                        {{ $product->short_description }}
                    </p>
                </div>
            @else
                <div style="height: 2.7rem; margin-bottom: 1rem;"></div>
            @endif

            <div class="d-flex justify-content-center align-items-center gap-2 mb-2 text-center">
                <div class="text-warning small">
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
                <span class="text-muted small">({{ $reviewCount }})</span>
            </div>
            
            <div class="text-center">
                @if($product->sale_price && $product->sale_price < $product->price)
                    <div class="d-flex justify-content-center align-items-baseline gap-2">
                        <span class="fs-5 fw-bold text-danger">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($product->sale_price, 2) }}</span>
                        <span class="text-muted text-decoration-line-through small">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($product->price, 2) }}</span>
                    </div>
                @else
                    <div class="fs-5 fw-bold text-primary-custom">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($product->price, 2) }}</div>
                @endif
            </div>
        </div>
    </a>
    
    <div class="card-footer bg-white border-0 text-center pb-3 pt-0">
        <button class="btn btn-primary-custom w-100 rounded-pill add-to-cart-btn p-card-btn {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}" data-product-id="{{ $product->id }}">
            <i class="fas fa-shopping-cart me-2"></i> {{ __('Add to Cart') }}
        </button>
    </div>
</div>
