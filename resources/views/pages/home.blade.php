@extends('layouts.app')

@push('styles')
<style>
    /* Text Animation inside Swiper (if needed) */
    .hero-content {
        opacity: 0;
        transform: translateX(-30px);
        transition: all 0.8s ease 0.3s;
    }
    .swiper-slide-active .hero-content {
        opacity: 1;
        transform: translateX(0);
    }
    
    .hero-image-container {
        opacity: 0;
        transform: translateX(30px);
        transition: all 0.8s ease 0.3s;
    }
    .swiper-slide-active .hero-image-container {
        opacity: 1;
        transform: translateX(0);
    }
    .hero-subtitle {
        text-transform: uppercase;
        letter-spacing: 4px;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 20px;
        display: inline-block;
    }
    .parallax-banner {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        padding: 100px 0;
        position: relative;
    }
    .parallax-banner::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(44, 44, 44, 0.7);
    }
    .icon-box {
        background-color: var(--background);
        border-radius: 10px;
        padding: 40px 20px;
        text-align: center;
        transition: transform 0.3s;
    }

    /* Mobile Slider Optimizations */
    @media (max-width: 767.98px) {
        .hero-slider {
            height: 50vh !important;
            min-height: 400px !important;
        }
        .hero-slider h1 {
            font-size: 2.5rem !important;
        }
        .hero-slider p {
            font-size: 1.1rem !important;
            margin-bottom: 2rem !important;
        }
        .hero-slider .btn {
            padding: 12px 30px !important;
            font-size: 0.95rem !important;
        }
        .swiper-button-next, .swiper-button-prev {
            display: none !important;
        }
    }

    /* RTL: Override hero slider button positions ONLY.
       Swiper uses its own CSS for positioning — Bootstrap RTL does not flip it.
       Do NOT touch .swiper-wrapper — Swiper's rtl:true handles slide direction internally. */
    [dir="rtl"] .swiper-button-next {
        right: auto !important;
        left: 20px !important;
    }
    [dir="rtl"] .swiper-button-prev {
        left: auto !important;
        right: 20px !important;
    }
</style>
@endpush

@section('content')
    <!-- Hero Slider -->
    <section class="hero-slider swiper w-100 mb-3 mb-md-5" style="height: 85vh; min-height: 650px; margin-top: -1px;">
        <div class="swiper-wrapper w-100 h-100">
            @foreach($banners as $banner)
                @php 
                  $bgImg = $banner->image ? asset($banner->image) : 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?q=80&w=1920&auto=format&fit=crop';
                @endphp
                <div class="swiper-slide position-relative w-100 h-100 d-flex align-items-center" style="background-image: url('{{ $bgImg }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                    @if(!empty($banner->button_link))
                        <a href="{{ $banner->button_link }}" class="position-absolute top-0 start-0 w-100 h-100 z-1" aria-label="{{ $banner->title }}"></a>
                    @endif
                    <!-- Dark Gradient Overlay for perfect text readability -->
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(90deg, rgba(14,12,10,0.85) 0%, rgba(14,12,10,0.6) 40%, rgba(14,12,10,0.1) 100%); z-index: 1;"></div>
                    
                    <div class="container position-relative z-2">
                        <div class="row">
                            <div class="col-lg-7 col-md-10 hero-content text-white ps-md-4">
                                <div class="d-flex align-items-center mb-4">
                                    <span class="d-inline-block bg-secondary-custom text-dark fw-bold px-3 py-1 me-3 rounded-0" style="font-size: 0.85rem; letter-spacing: 2px;">{{ __('NEW ARRIVAL') }}</span>
                                    <h6 class="fw-bold mb-0 text-white d-none d-sm-block" style="font-size: 1rem; text-transform: uppercase; letter-spacing: 4px;">{{ __('Exclusive Collection') }}</h6>
                                </div>
                                
                                <h1 class="display-2 fw-bold mb-4 mb-md-4 lh-sm text-white" style="letter-spacing: -2px; font-family: 'Playfair Display', serif; text-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                                    {{ $banner->title ?? 'Elevate Your Space' }}
                                </h1>
                                
                                <p class="fs-4 text-light mb-4 mb-md-5" style="font-weight: 300; max-width: 600px; line-height: 1.6; text-shadow: 0 2px 10px rgba(0,0,0,0.2);">
                                    {{ $banner->subtitle ?? 'Discover our new collection of modern, stylish, and comfortable luxury furniture.' }}
                                </p>
                                
                                <div class="d-flex align-items-center gap-4">
                                    <a href="{{ $banner->button_link ?? route('shop.index') }}" class="btn btn-secondary-custom rounded-pill px-5 py-3 fw-bold shadow-lg" style="font-size: 1.1rem; transition: all 0.3s ease; border: 2px solid var(--secondary);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.3) !important';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px rgba(0,0,0,0.15) !important';">
                                        {{ $banner->button_text ?? 'Explore Collection' }} <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Swiper Navigation (Desktop only) -->
        <div class="swiper-button-next text-white d-none d-md-flex" style="width: 50px; height: 50px; right: 20px; background: rgba(0,0,0,0.15); border-radius: 50%;"></div>
        <div class="swiper-button-prev text-white d-none d-md-flex" style="width: 50px; height: 50px; left: 20px; background: rgba(0,0,0,0.15); border-radius: 50%;"></div>
        <div class="swiper-pagination mb-2 mb-md-4 custom-swiper-pagination"></div>
    </section>

    <!-- Categories Row -->
    <section class="py-5" style="background-color: #F8F5F0;">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div>
                     <span class="text-secondary-custom fw-bold text-uppercase" style="letter-spacing: 2px; font-size: 0.85rem;">{{ __('Health Solutions') }}</span>
                     <h2 class="playfair display-5 mb-0 mt-2 text-dark">{{ __('Shop by Category') }}</h2>
                     <div class="bg-primary-custom mt-3" style="height: 3px; width: 60px;"></div>
                </div>
                <button type="button" id="toggleCategoriesBtn" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-semibold" style="border-width: 2px; display: none;">{{ __('View All Categories') }}</button>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($categories as $category)
                    @php 
                        $catImg = $category->image ? asset($category->image) : 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=800&auto=format&fit=crop';
                    @endphp
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 category-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="text-decoration-none text-dark d-block h-100 group-hover">
                            <div class="card border-0 rounded-4 overflow-hidden h-100 shadow-sm" style="transition: all 0.4s ease; cursor: pointer; background-color: var(--white);" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.1) !important';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075) !important';">
                                <div class="position-relative" style="height: 240px; overflow: hidden;">
                                            <img src="{{ $catImg }}" loading="lazy" class="w-100 h-100 object-fit-cover" alt="{{ $category->name }}" style="transition: transform 0.6s ease;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                                </div>
                                <div class="card-body bg-white text-center py-4" style="z-index: 2; position: relative;">
                                    <h5 class="playfair fw-bold mb-2 text-primary-custom" style="font-size: 1.3rem;">{{ $category->name }}</h5>
                                    <span class="text-secondary-custom small fw-semibold text-uppercase" style="letter-spacing: 1.5px;">Shop Now <i class="fas fa-arrow-right ms-1"></i></span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products (Best Sellers Slider) -->
    <section class="py-5 bg-white">
        <div class="container py-4 py-md-5">
            <div class="d-flex justify-content-between align-items-end mb-4 mb-md-5" data-aos="fade-up">
                <div>
                     <span class="text-secondary-custom fw-bold text-uppercase" style="letter-spacing: 2px; font-size: 0.85rem;">{{ __('Popular Choice') }}</span>
                     <h2 class="playfair display-5 mb-0 mt-2 text-dark">{{ __('Our Best Sellers') }}</h2>
                     <div class="bg-primary-custom mt-3" style="height: 3px; width: 60px;"></div>
                </div>
                <div class="d-flex gap-2">
                    @if(app()->getLocale() == 'ur')
                        <button class="btn btn-outline-dark rounded-circle best-sellers-next" style="width: 45px; height: 45px;"><i class="fas fa-chevron-left"></i></button>
                        <button class="btn btn-outline-dark rounded-circle best-sellers-prev" style="width: 45px; height: 45px;"><i class="fas fa-chevron-right"></i></button>
                    @else
                        <button class="btn btn-outline-dark rounded-circle best-sellers-prev" style="width: 45px; height: 45px;"><i class="fas fa-chevron-left"></i></button>
                        <button class="btn btn-outline-dark rounded-circle best-sellers-next" style="width: 45px; height: 45px;"><i class="fas fa-chevron-right"></i></button>
                    @endif
                </div>
            </div>
            
            <div class="swiper best-sellers-slider pb-4">
                <div class="swiper-wrapper">
                    @foreach($featuredProducts as $product)
                        <div class="swiper-slide h-auto">
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="text-center mt-4 mt-md-5">
                <a href="{{ route('shop.index') }}" class="btn btn-outline-dark btn-lg rounded-pill px-5 border-2 text-uppercase fw-bold" style="font-size: 0.9rem;">{{ __('View All Products') }}</a>
            </div>
        </div>
    </section>

    <!-- Promotional Banner -->
    @php
        $promoImage = $globalSettings['promo_banner_image'] ?? 'https://picsum.photos/seed/promo/1920/600';
    @endphp
    <section class="parallax-banner text-center position-relative" style="background-image: url('{{ asset($promoImage) }}');">
        @php $promoLink = $globalSettings['promo_banner_btn_link'] ?? route('shop.index', ['sale' => 'true']); @endphp
        <a href="{{ $promoLink }}" class="position-absolute top-0 start-0 w-100 h-100 z-0" aria-label="View Sale"></a>
        <div class="container position-relative z-1 text-white py-5">
            <h2 class="playfair display-4 mb-4" data-aos="fade-up">{{ $globalSettings['promo_banner_title'] ?? 'Authentic Herbal Medicines' }}</h2>
            <p class="lead mb-5" data-aos="fade-up" data-aos-delay="100">{{ $globalSettings['promo_banner_subtitle'] ?? 'Natural healing for a healthier life, delivered to your doorstep.' }}</p>
            
            <div class="d-flex justify-content-center gap-4 mb-5" data-aos="fade-up" data-aos-delay="200" id="promo-countdown">
                <div class="bg-white text-dark rounded-3 p-3 shadow text-center" style="min-width: 80px;">
                    <h3 class="fw-bold mb-0" id="days">00</h3><small>{{ __('Days') }}</small>
                </div>
                <div class="bg-white text-dark rounded-3 p-3 shadow text-center" style="min-width: 80px;">
                    <h3 class="fw-bold mb-0" id="hours">00</h3><small>{{ __('Hours') }}</small>
                </div>
                <div class="bg-white text-dark rounded-3 p-3 shadow text-center" style="min-width: 80px;">
                    <h3 class="fw-bold mb-0" id="minutes">00</h3><small>{{ __('Mins') }}</small>
                </div>
                <div class="bg-white text-dark rounded-3 p-3 shadow text-center d-none d-sm-block" style="min-width: 80px;">
                    <h3 class="fw-bold mb-0" id="seconds">00</h3><small>{{ __('Secs') }}</small>
                </div>
            </div>

            <a href="{{ $globalSettings['promo_banner_btn_link'] ?? route('shop.index', ['sale' => 'true']) }}" class="btn btn-secondary-custom btn-lg rounded-pill px-5" data-aos="fade-up" data-aos-delay="300">
                {{ $globalSettings['promo_banner_btn_text'] ?? 'Explore Now' }}
            </a>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-5" style="background-color: var(--background);">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="playfair display-5 mb-3 text-dark">{{ __('Why Choose Us') }}</h2>
                <div class="mx-auto bg-primary-custom" style="height: 3px; width: 60px;"></div>
            </div>
            <div class="row g-4">
                @php
                    $features = json_decode($globalSettings['site_why_choose_us'] ?? '[]', true);
                @endphp
                @forelse($features as $feature)
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="icon-box">
                            <i class="{{ $feature['icon'] ?? 'fas fa-check' }} mb-3 fs-1 text-primary-custom"></i>
                            <h4 class="playfair mb-3 text-dark">{{ $feature['title'] ?? 'Feature' }}</h4>
                            <p class="text-dark mb-0">{{ $feature['desc'] ?? '' }}</p>
                        </div>
                    </div>
                @empty
                    <!-- Fallback if empty -->
                    <div class="col-md-6 col-lg-3"><div class="icon-box"><i class="fas fa-truck-fast mb-3 fs-1 text-primary-custom"></i><h4 class="playfair mb-3 text-dark">{{ __('Free Shipping') }}</h4><p class="text-dark mb-0">{{ __('Enjoy free shipping on all orders over') }} {{ $globalSettings['currency_symbol'] ?? '$' }} 500.</p></div></div>
                    <div class="col-md-6 col-lg-3"><div class="icon-box"><i class="fas fa-undo-alt mb-3 fs-1 text-primary-custom"></i><h4 class="playfair mb-3 text-dark">{{ __('Easy Returns') }}</h4><p class="text-dark mb-0">{{ __('Return your item within 30 days for a refund.') }}</p></div></div>
                    <div class="col-md-6 col-lg-3"><div class="icon-box"><i class="fas fa-shield-alt mb-3 fs-1 text-primary-custom"></i><h4 class="playfair mb-3 text-dark">{{ __('Quality Guarantee') }}</h4><p class="text-dark mb-0">{{ __('We stand behind our craftsmanship.') }}</p></div></div>
                    <div class="col-md-6 col-lg-3"><div class="icon-box"><i class="fas fa-headset mb-3 fs-1 text-primary-custom"></i><h4 class="playfair mb-3 text-dark">{{ __('24/7 Support') }}</h4><p class="text-dark mb-0">{{ __('Our dedicated team is here to assist you.') }}</p></div></div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- New Arrivals Slider -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div>
                    <h2 class="playfair display-5 mb-2 text-dark">{{ __('New Arrivals') }}</h2>
                    <div class="bg-secondary-custom" style="height: 3px; width: 60px;"></div>
                </div>
                <div class="d-flex gap-2">
                    @if(app()->getLocale() == 'ur')
                        <button class="btn btn-outline-dark rounded-circle new-arrivals-next" style="width: 45px; height: 45px;"><i class="fas fa-chevron-left"></i></button>
                        <button class="btn btn-outline-dark rounded-circle new-arrivals-prev" style="width: 45px; height: 45px;"><i class="fas fa-chevron-right"></i></button>
                    @else
                        <button class="btn btn-outline-dark rounded-circle new-arrivals-prev" style="width: 45px; height: 45px;"><i class="fas fa-chevron-left"></i></button>
                        <button class="btn btn-outline-dark rounded-circle new-arrivals-next" style="width: 45px; height: 45px;"><i class="fas fa-chevron-right"></i></button>
                    @endif
                </div>
            </div>

            <div class="swiper new-arrivals-slider pb-4">
                <div class="swiper-wrapper">
                    @foreach($newArrivals as $product)
                        <div class="swiper-slide h-auto">
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="py-5" style="background-color: var(--background);">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="playfair display-5 mb-3 text-dark">{{ __('Health & Wellness Tips') }}</h2>
                <div class="mx-auto bg-primary-custom" style="height: 3px; width: 80px;"></div>
                <p class="text-dark mt-3">{{ __('Expert advice on herbal remedies and daily wellness.') }}</p>
            </div>
            
            <div class="row g-4">
                @foreach($posts as $post)
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        @include('partials.blog-card', ['post' => $post])
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('blog.index') }}" class="btn btn-outline-dark border-2 rounded-pill px-5 fw-bold text-uppercase">{{ __('Read All Articles') }}</a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="playfair display-5 mb-3 text-dark">{{ __('What Our Clients Say') }}</h2>
                <div class="mx-auto bg-secondary-custom" style="height: 3px; width: 60px;"></div>
            </div>
            
            <div class="swiper testimonial-slider col-lg-8 mx-auto position-relative pb-5">
                <div class="swiper-wrapper">
                    @foreach($reviews as $review)
                        <div class="swiper-slide text-center px-4">
                            <i class="fas fa-quote-left fs-1 text-secondary-custom opacity-25 mb-4"></i>
                            <p class="fs-4 fst-italic mb-4" style="color: var(--text-dark);">"{{ $review->body }}"</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <img src="https://picsum.photos/seed/{{ $review->user->id }}/80/80" class="rounded-circle me-3 border border-3 border-white shadow-sm" alt="{{ $review->user->name }}">
                                <div class="text-start">
                                    <h5 class="playfair mb-0">{{ $review->user->name }}</h5>
                                    <div class="text-warning small pt-1">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-muted opacity-50' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-5 text-center" style="background-color: var(--primary);">
        <div class="container py-5 text-white">
            <div class="col-lg-6 mx-auto" data-aos="zoom-in">
                <h2 class="playfair display-5 mb-3 text-white">{{ __('Join 5,000+ Healthy Customers') }}</h2>
                <p class="lead mb-4 text-white" style="opacity: 0.8;">{{ __('Subscribe to our newsletter for health tips, early access to new herbal remedies, and exclusive offers.') }}</p>
                
                <form id="newsletter-form" class="d-flex gap-2 mx-auto bg-white p-2 rounded-pill shadow-sm">
                    @csrf
                    <input type="email" name="email" class="form-control border-0 rounded-pill px-4 shadow-none" placeholder="Your email address..." required>
                    <button type="submit" id="newsletter-submit" class="btn btn-secondary-custom rounded-pill px-5 fw-bold">Subscribe</button>
                </form>
                <div id="newsletter-message" class="mt-3 text-start ps-4" style="display: none;"></div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Hero Slider
        const isRtl = document.documentElement.getAttribute('dir') === 'rtl';
        new Swiper('.hero-slider', {
            loop: true,
            effect: 'fade',
            rtl: isRtl,
            autoplay: {
                delay: 5000,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });

        // Best Sellers Slider
        new Swiper('.best-sellers-slider', {
            slidesPerView: 1,
            spaceBetween: 15,
            loop: true,
            rtl: isRtl,
            navigation: {
                nextEl: '.best-sellers-next',
                prevEl: '.best-sellers-prev',
            },
            breakpoints: {
                576: { slidesPerView: 2, spaceBetween: 20 },
                768: { slidesPerView: 3, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 25 }
            }
        });

        // New Arrivals Slider
        new Swiper('.new-arrivals-slider', {
            slidesPerView: 1,
            spaceBetween: 15,
            loop: true,
            rtl: isRtl,
            navigation: {
                nextEl: '.new-arrivals-next',
                prevEl: '.new-arrivals-prev',
            },
            breakpoints: {
                576: { slidesPerView: 2, spaceBetween: 20 },
                768: { slidesPerView: 3, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 25 }
            }
        });

        // Testimonial Slider
        new Swiper('.testimonial-slider', {
            loop: true,
            rtl: isRtl,
            autoplay: {
                delay: 4000,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });

        // Newsletter Form AJAX
        const newsletterForm = document.getElementById('newsletter-form');
        const newsletterMessage = document.getElementById('newsletter-message');
        const newsletterSubmit = document.getElementById('newsletter-submit');

        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const originalText = newsletterSubmit.innerHTML;
                
                newsletterSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Subscribing...';
                newsletterSubmit.disabled = true;
                newsletterMessage.style.display = 'none';
                
                fetch('{{ route('subscribe') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Identify as AJAX request to Laravel
                    }
                })
                .then(response => response.json().then(data => ({status: response.status, body: data})))
                .then(result => {
                    newsletterSubmit.innerHTML = originalText;
                    newsletterSubmit.disabled = false;
                    
                    newsletterMessage.style.display = 'block';
                    
                    if (result.status === 200 || result.body.status === 'success') {
                        newsletterMessage.innerHTML = `<span class="badge bg-success py-2 px-3 fw-normal shadow-sm"><i class="fas fa-check-circle me-1"></i> ${result.body.message}</span>`;
                        newsletterForm.reset();
                        
                        // Hide message after 5 seconds on success
                        setTimeout(() => {
                            newsletterMessage.style.display = 'none';
                        }, 5000);
                    } else {
                        newsletterMessage.innerHTML = `<span class="badge bg-danger py-2 px-3 fw-normal shadow-sm"><i class="fas fa-exclamation-circle me-1"></i> ${result.body.message || 'Something went wrong.'}</span>`;
                    }
                })
                .catch(error => {
                    newsletterSubmit.innerHTML = originalText;
                    newsletterSubmit.disabled = false;
                    newsletterMessage.style.display = 'block';
                    newsletterMessage.innerHTML = `<span class="badge bg-danger py-2 px-3 fw-normal shadow-sm"><i class="fas fa-exclamation-circle me-1"></i> An error occurred. Please try again.</span>`;
                });
            });
        }

        // Promotional Countdown
        @if(isset($globalSettings['promo_banner_countdown']))
        const countDownDate = new Date("{{ $globalSettings['promo_banner_countdown'] }}").getTime();
        
        const countdownInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = countDownDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            const daysEl = document.getElementById("days");
            const hoursEl = document.getElementById("hours");
            const minutesEl = document.getElementById("minutes");
            const secondsEl = document.getElementById("seconds");

            if(daysEl) daysEl.innerHTML = days < 10 ? "0" + days : days;
            if(hoursEl) hoursEl.innerHTML = hours < 10 ? "0" + hours : hours;
            if(minutesEl) minutesEl.innerHTML = minutes < 10 ? "0" + minutes : minutes;
            if(secondsEl) secondsEl.innerHTML = seconds < 10 ? "0" + seconds : seconds;

            if (distance < 0) {
                clearInterval(countdownInterval);
                document.getElementById("promo-countdown").innerHTML = "<h3 class='text-white playfair'>OFFER EXPIRED</h3>";
            }
        }, 1000);
        @endif
        
        // Category Visibility Logic
        const categoryItems = document.querySelectorAll('.category-item');
        const toggleBtn = document.getElementById('toggleCategoriesBtn');
        let isExpanded = false;
        
        function updateCategoryVisibility() {
            if (!categoryItems.length || !toggleBtn) return;
            
            const width = window.innerWidth;
            let limit = 4; // desktop
            
            if (width < 768) {
                limit = 2; // mobile
            } else if (width < 992) {
                limit = 3; // small/tablet
            }
            
            if (categoryItems.length > limit) {
                toggleBtn.style.display = 'inline-block';
            } else {
                toggleBtn.style.display = 'none';
            }
            
            categoryItems.forEach((item, index) => {
                if (isExpanded || index < limit) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
        
        if (categoryItems.length > 0 && toggleBtn) {
            updateCategoryVisibility();
            window.addEventListener('resize', updateCategoryVisibility);
            
            toggleBtn.addEventListener('click', function() {
                isExpanded = !isExpanded;
                if (isExpanded) {
                    toggleBtn.textContent = '{{ __("View Less") }}';
                } else {
                    toggleBtn.textContent = '{{ __("View All Categories") }}';
                }
                updateCategoryVisibility();
                
                // Re-initialize AOS if expanded items are shown
                if (isExpanded && typeof AOS !== 'undefined') {
                    setTimeout(() => AOS.refresh(), 100);
                }
            });
        }
    });
</script>
@endpush
