@php
    use App\Services\SeoService;
    $seoService = new SeoService();
@endphp

@extends('layouts.app')

@push('seo_tags')
    <!-- Product SEO Tags -->
    <link rel="canonical" href="{{ route('product.show', $product->slug) }}">
    <meta name="description" content="{{ $product->short_description ? strip_tags($product->short_description) : Str::limit($product->description, 160) }}">
    <meta name="keywords" content="{{ $product->name }}, {{ $product->category->name ?? 'product' }}, hakami, dawae, Pakistan">
    
    <!-- Product-specific Open Graph -->
    <meta property="og:title" content="{{ $product->name }} - {{ $globalSettings['site_name'] ?? 'dwakhana' }}">
    <meta property="og:description" content="{{ $product->short_description ? strip_tags($product->short_description) : Str::limit($product->description, 160) }}">
    <meta property="og:image" content="{{ $product->main_image }}">
    <meta property="og:url" content="{{ route('product.show', $product->slug) }}">
    <meta property="og:type" content="product">
    
    <!-- Hreflang for Urdu/English -->
    <link rel="alternate" hreflang="en" href="{{ url('/en/product/' . $product->slug) }}">
    <link rel="alternate" hreflang="ur" href="{{ url('/ur/product/' . $product->slug) }}">
    <link rel="alternate" hreflang="x-default" href="{{ url('/product/' . $product->slug) }}">
    
    <!-- Product Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {!! json_encode($seoService->generateProductSchema($product), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    
    <!-- Breadcrumb Structured Data -->
    <script type="application/ld+json">
    {!! json_encode($seoService->generateBreadcrumbSchema([
        __('Home') => route('home'),
        __('Shop') => route('shop.index'),
        $product->category->name => route('shop.index', ['category' => $product->category->slug]),
        $product->name => route('product.show', $product->slug)
    ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@push('styles')
<style>
    .product-main-gallery {
        border-radius: 15px;
        overflow: hidden;
        background: #fdfdfd;
    }
    .product-main-gallery .swiper-slide img {
        transition: transform 0.5s ease;
    }
    .product-main-gallery .swiper-slide:hover img {
        transform: scale(1.05);
    }
    .gallery-thumb {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 12px;
        cursor: pointer;
        opacity: 0.5;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    .product-thumb-gallery .swiper-slide-thumb-active .gallery-thumb {
        opacity: 1;
        border-color: var(--secondary);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    /* Modern Underline Tabs */
    .modern-tabs .nav-link {
        color: #999;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
        padding: 1rem 2rem;
        position: relative;
        background: transparent !important;
        transition: color 0.3s ease;
    }
    .modern-tabs .nav-link.active {
        color: var(--primary) !important;
    }
    .modern-tabs .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 3px;
        background: var(--primary);
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }
    .modern-tabs .nav-link.active::after {
        width: 100%;
    }
    
    .qty-control {
        background: #f8f9fa;
        border-radius: 30px;
        padding: 5px;
        display: inline-flex;
        align-items: center;
        border: 1px solid #eee;
    }
    .qty-btn {
        width: 40px;
        height: 40px;
        border-radius: 50% !important;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .qty-btn:hover {
        background: var(--primary) !important;
        color: white !important;
    }
</style>
@endpush

@section('content')
    <div class="bg-light border-bottom py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size: 0.85rem;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none text-muted">{{ __('Shop') }}</a></li>
                    <li class="breadcrumb-item active fw-bold text-primary-custom" aria-current="page">{{ Str::limit($product->name, 30) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5 bg-white">
        <div class="container py-3 py-md-5 mt-md-4">
            <div class="row gx-lg-5 g-4">
                <!-- Product Gallery -->
                <div class="col-lg-6">
                    <!-- Main Swiper -->
                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper product-main-gallery mb-4 shadow-sm border">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide position-relative">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-4 z-3 shadow-lg px-3 py-2 fs-6">{{ __('SALE') }}</span>
                                @endif
                                <img src="{{ $product->main_image }}" loading="lazy" class="w-100 object-fit-cover" style="height: 600px; display: block;" alt="{{ $product->name }}" />
                            </div>
                            @foreach($product->images as $img)
                                <div class="swiper-slide">
                                    <img src="{{ $img->image_path }}" loading="lazy" class="w-100 object-fit-cover" style="height: 600px; display: block;" alt="{{ $product->name }}" />
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next text-dark"></div>
                        <div class="swiper-button-prev text-dark"></div>
                    </div>
                    
                    <!-- Thumb Swiper -->
                    <div thumbsSlider="" class="swiper product-thumb-gallery px-1">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{{ $product->main_image }}" loading="lazy" class="gallery-thumb border" alt="{{ $product->name }}" />
                            </div>
                            @foreach($product->images as $img)
                                <div class="swiper-slide">
                                    <img src="{{ $img->image_path }}" loading="lazy" class="gallery-thumb border" alt="{{ $product->name }}" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right: Info -->
                <div class="col-lg-6 ps-lg-5">
                    {{-- Category removed as per modern UI request --}}
                    
                    <h1 class="playfair display-4 fw-bold mb-3 text-dark">{{ $product->name }}</h1>
                    
                    <div class="d-flex align-items-center mb-4 gap-3">
                        <div class="text-warning fs-5">
                            @php
                                $avgRating = $product->reviews->avg('rating') ?: 0;
                                $fullStars = floor($avgRating);
                                $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <i class="fas fa-star"></i>
                                @elseif($i == ($fullStars + 1) && $hasHalfStar)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                            {{ number_format($avgRating, 1) }} ({{ $product->reviews->count() }} {{ __('customer reviews') }})
                    </div>

                    <div class="d-flex align-items-baseline gap-3 mb-4">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="fs-1 fw-bold text-danger">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($product->sale_price, 2) }}</span>
                            <span class="text-muted text-decoration-line-through fs-4">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($product->price, 2) }}</span>
                        @else
                            <span class="fs-1 fw-bold text-primary-custom">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <p class="text-muted fs-5 mb-5 lh-base" style="max-width: 500px;">{{ $product->short_description }}</p>
                    
                    <div class="bg-light p-4 rounded-4 mb-5 border">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-white p-2 rounded shadow-sm text-success"><i class="fas fa-check-circle fs-4"></i></div>
                                    <div>
                                        <div class="small text-muted">{{ __('Availability') }}</div>
                                        <div class="fw-bold text-dark">{{ $product->stock_quantity > 0 ? __('In Stock') . ' (' . $product->stock_quantity . ')' : __('Out of Stock') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-white p-2 rounded shadow-sm text-secondary-custom"><i class="fas fa-barcode fs-4"></i></div>
                                    <div>
                                        <div class="small text-muted">{{ __('SKU') }}</div>
                                        <div class="fw-bold text-dark">{{ $product->sku ?: 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 border-secondary">

                    <form id="addToCartForm" data-product-id="{{ $product->id }}" class="mb-5">
                        <div class="d-flex flex-column gap-3" style="max-width: 400px;">
                            <!-- Top Row: Quantity and Heart -->
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="qty-control shadow-sm bg-white">
                                    <button class="btn qty-btn border-0" type="button" onclick="let input = document.getElementById('qtyInput'); if(input.value > 1) input.value--;"><i class="fas fa-minus fs-6"></i></button>
                                    <input type="text" id="qtyInput" class="form-control border-0 text-center fw-bold bg-transparent p-0" value="1" style="width: 40px; font-size: 1.1rem;" readonly>
                                    <button class="btn qty-btn border-0" type="button" onclick="let input = document.getElementById('qtyInput'); if(input.value < {{ $product->stock_quantity }}) input.value++;"><i class="fas fa-plus fs-6"></i></button>
                                </div>

                                @php
                                    $inWishlist = auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists();
                                @endphp
                                <button type="button" class="btn btn-outline-secondary rounded-circle toggle-wishlist d-flex align-items-center justify-content-center transition shadow-sm hover-lift flex-shrink-0" data-product-id="{{ $product->id }}" style="width: 52px; height: 52px; border-width: 1px;">
                                    <i class="{{ $inWishlist ? 'fas fa-heart text-danger' : 'far fa-heart' }} fs-5"></i>
                                </button>
                            </div>
                            
                            <!-- Bottom Row: Add to Cart -->
                            <button type="submit" class="btn btn-primary-custom btn-lg rounded-pill w-100 py-3 fw-bold transition shadow-lg d-flex align-items-center justify-content-center {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}" style="font-size: 1rem; min-height: 52px; white-space: nowrap;">
                                <i class="fas fa-shopping-bag me-2"></i> <span class="text-uppercase">{{ __('Add To Cart') }}</span>
                            </button>
                        </div>
                    </form>

                    @php
                        $socialLinks = json_decode($globalSettings['site_social_links'] ?? '[]', true);
                        $currentUrl = urlencode(url()->current());
                        $productName = urlencode($product->name);
                        $productImage = urlencode(asset($product->main_image));
                    @endphp
                    {{-- Share icons repositioned for mobile --}}
                    <div class="d-none d-lg-flex align-items-center gap-3">
                        <span class="text-muted fw-bold">{{ __('Share:') }}</span>
                        @include('partials.product-share-links')
                    </div>
                </div>
            </div>
            
            <!-- Tabs Below Fold -->
            <div class="row mt-5 pt-5">
                <div class="col-12">
                    <ul class="nav nav-tabs modern-tabs justify-content-center mb-5 border-bottom-0" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab">{{ __('The Description') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab">{{ __('Reviews') }} ({{ $product->reviews->count() }})</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab">{{ __('Shipping & Returns') }}</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content bg-transparent" id="productTabsContent">
                        <div class="tab-pane fade show active" id="desc" role="tabpanel">
                            <div class="bg-light p-5 rounded-4 border shadow-sm">
                                <h4 class="playfair display-6 mb-4">{{ __('Detailed Description') }}</h4>
                                <div class="text-muted lh-lg fs-5">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="review" role="tabpanel">
                            <div class="row">
                                <div class="col-md-7">
                                    <h4 class="playfair mb-4">{{ __('Customer Reviews') }}</h4>
                                    @forelse($product->reviews as $review)
                                        <div class="d-flex mb-4 pb-4 border-bottom">
                                            <div class="me-3">
                                                <div class="bg-primary-custom text-white d-flex align-items-center justify-content-center rounded-circle fs-5 fw-bold shadow-sm" style="width: 54px; height: 54px; opacity: 0.9;">
                                                    {{ substr($review->user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <div>
                                                        <h6 class="mb-0 fw-bold text-dark">{{ $review->user->name }}</h6>
                                                        <span class="text-muted small">{{ $review->created_at->format('M d, Y') }}</span>
                                                    </div>
                                                    <div class="text-warning small">
                                                        @for($i=1; $i<=5; $i++)
                                                            <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-muted opacity-25' }}"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <h6 class="fw-bold mb-2">{{ $review->title }}</h6>
                                                <p class="text-muted mb-0 lh-base">{{ $review->body }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-muted">{{ __('No reviews yet. Be the first to review this product!') }}</p>
                                    @endforelse
                                </div>
                                <div class="col-md-5">
                                    <div class="bg-white p-4 rounded-3 border">
                                        <h5 class="playfair mb-3">{{ __('Write a Review') }}</h5>
                                        @auth
                                            @php
                                                $hasReviewed = \App\Models\Review::where('product_id', $product->id)->where('user_id', auth()->id())->exists();
                                            @endphp
                                            @if($hasReviewed)
                                                <div class="alert alert-info border-0 shadow-sm mt-3">
                                                    <i class="fas fa-info-circle me-2"></i> {{ __('You have already submitted a review for this product. Thank you!') }}
                                                </div>
                                            @else
                                                <form action="{{ route('review.store', $product->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="rating" id="reviewRating" value="5">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Your Rating') }}</label>
                                                        <div class="text-warning fs-4 cursor-pointer" id="starRatingContainer">
                                                            <i class="fas fa-star" data-rating="1"></i>
                                                            <i class="fas fa-star" data-rating="2"></i>
                                                            <i class="fas fa-star" data-rating="3"></i>
                                                            <i class="fas fa-star" data-rating="4"></i>
                                                            <i class="fas fa-star" data-rating="5"></i>
                                                        </div>
                                                        @error('rating')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Review Title') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="title" class="form-control shadow-none" required value="{{ old('title') }}">
                                                        @error('title')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Your Comment') }} <span class="text-danger">*</span></label>
                                                        <textarea name="body" class="form-control shadow-none" rows="4" required>{{ old('body') }}</textarea>
                                                        @error('body')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="btn btn-primary-custom w-100">{{ __('Submit Review') }}</button>
                                                </form>
                                            @endif
                                        @else
                                            <div class="text-center p-4 bg-light rounded text-muted mt-3">
                                                <i class="fas fa-lock fs-3 mb-2"></i>
                                                <p class="mb-3">{{ __('Please log in to leave a review') }}</p>
                                                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm px-4 rounded-pill">{{ __('Log In') }}</a>
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="shipping" role="tabpanel">
                            <div class="bg-white p-5 rounded-4 border shadow-sm">
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <h4 class="playfair mb-4" dir="auto"><i class="fas fa-truck me-2 text-primary"></i> {{ $shippingPage->title ?? __('Shipping Policy') }}</h4>
                                        <div class="text-muted lh-base" dir="auto">
                                            @if($shippingPage)
                                                {!! $shippingPage->content !!}
                                            @else
                                                <p>{{ __('We offer fast and reliable shipping for all our furniture pieces.') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="playfair mb-4" dir="auto"><i class="fas fa-undo me-2 text-primary"></i> {{ $returnsPage->title ?? __('Easy Returns') }}</h4>
                                        <div class="text-muted lh-base" dir="auto">
                                            @if($returnsPage)
                                                {!! $returnsPage->content !!}
                                            @else
                                                <p>{{ __('Not satisfied? We accept returns within 30 days of delivery.') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-5 pt-5 border-top">
                    <div class="d-flex d-lg-none align-items-center justify-content-center gap-3 mb-5 py-3 border rounded-pill bg-light mx-auto" style="max-width: 300px;">
                        <span class="text-muted fw-bold">{{ __('Share:') }}</span>
                        @include('partials.product-share-links')
                    </div>
                    
                    <h2 class="playfair display-6 text-center mb-5">{{ __('You May Also Like') }}</h2>
                    <div class="row g-4">
                        @foreach($relatedProducts as $relProduct)
                            <div class="col-sm-6 col-md-3">
                                @include('partials.product-card', ['product' => $relProduct])
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<style>
    .nav-pills .nav-link.active {
        background-color: var(--primary) !important;
        color: white !important;
    }
    .nav-pills .nav-link {
        color: var(--text-dark);
        font-weight: 500;
        border: 1px solid transparent;
    }
    .nav-pills .nav-link:hover {
        border-color: var(--border);
    }
    .hover-gold:hover i {
        color: var(--secondary) !important;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var swiperThumb = new Swiper(".product-thumb-gallery", {
            spaceBetween: 15,
            slidesPerView: 3,
            freeMode: true,
            watchSlidesProgress: true,
            breakpoints: {
                480: { slidesPerView: 4 },
                768: { slidesPerView: 5 }
            }
        });
        var swiperMain = new Swiper(".product-main-gallery", {
            spaceBetween: 0,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiperThumb,
            },
        });

        // Reviews Star Interactions
        const starContainer = document.getElementById('starRatingContainer');
        if (starContainer) {
            const stars = starContainer.querySelectorAll('i');
            const ratingInput = document.getElementById('reviewRating');

            function highlightStars(rating) {
                stars.forEach(star => {
                    if (star.getAttribute('data-rating') <= rating) {
                        star.classList.replace('far', 'fas');
                    } else {
                        star.classList.replace('fas', 'far');
                    }
                });
            }

            stars.forEach(star => {
                star.addEventListener('mouseover', function() {
                    let rating = this.getAttribute('data-rating');
                    highlightStars(rating);
                });

                star.addEventListener('mouseleave', function() {
                    let currentRating = ratingInput.value;
                    highlightStars(currentRating);
                });

                star.addEventListener('click', function() {
                    let rating = this.getAttribute('data-rating');
                    ratingInput.value = rating;
                    highlightStars(rating);
                });
            });
        }
    });
</script>
@endpush
