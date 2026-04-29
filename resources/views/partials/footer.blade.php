@php
    $currentLocale = app()->getLocale();
    $footerPages = \App\Models\Page::where('locale', $currentLocale)
        ->active()
        ->get(['title', 'slug']);

    // Fallback for missing locales: If no pages exist for current locale, show English ones
    if ($footerPages->isEmpty() && $currentLocale !== 'en') {
        $footerPages = \App\Models\Page::where('locale', 'en')
            ->active()
            ->get(['title', 'slug']);
    }
@endphp
<footer class="bg-primary-custom pt-5 pb-3">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 text-white">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <h3 class="mb-3 text-white" style="font-family: 'Playfair Display', serif; letter-spacing: -1px; font-weight: 700;">
                        <img src="{{ asset('storage/settings/XxkHVaHPreip4SouIaDyPcSwyqTbick49TKyBP22.jpg') }}" alt="{{ $globalSettings['site_name'] ?? 'dwakhana' }}" style="max-height: 40px; margin-right: 10px; background: white; padding: 2px; border-radius: 4px;">
                        {{ $globalSettings['site_name'] ?? 'dwakhana' }}
                    </h3>
                </a>
                <p class="text-light" style="opacity: 0.8;">{{ $globalSettings['footer_description'] ?? 'Premium furniture for your modern lifestyle. Handcrafted with passion and exceptional quality designed to last a lifetime.' }}</p>
                <div class="d-flex gap-3 mt-4">
                    @php
                        $socialLinks = json_decode($globalSettings['site_social_links'] ?? '[]', true);
                    @endphp
                    @foreach($socialLinks as $social)
                        <a href="{{ $social['url'] }}" class="text-white fs-5" target="_blank"><i class="{{ $social['icon'] }}"></i></a>
                    @endforeach
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6">
                <h5 class="text-white mb-3">{{ __('Quick Links') }}</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-light text-decoration-none" style="opacity: 0.8;">{{ __('Home') }}</a></li>
                    <li class="mb-2"><a href="{{ route('shop.index') }}" class="text-light text-decoration-none" style="opacity: 0.8;">{{ __('Shop') }}</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}" class="text-light text-decoration-none" style="opacity: 0.8;">{{ __('About Us') }}</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-light text-decoration-none" style="opacity: 0.8;">{{ __('Contact') }}</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h5 class="text-white mb-3">{{ __('Customer Service') }}</h5>
                <ul class="list-unstyled">
                    @foreach($footerPages as $fPage)
                        <li class="mb-2">
                            <a href="{{ route('pages.show', $fPage->slug) }}" class="text-light text-decoration-none" style="opacity: 0.8;">
                                {{ $fPage->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="text-white mb-3">{{ __('Contact Us') }}</h5>
                <ul class="list-unstyled text-light" style="opacity: 0.8;">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> {{ $globalSettings['site_address'] ?? '123 Atta HQ, NY 10001' }}</li>
                    <li class="mb-2"><i class="fas fa-phone me-2"></i> {{ $globalSettings['site_phone'] ?? '1-800-FURNITURE' }}</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2"></i> {{ $globalSettings['site_email'] ?? 'hello@attafurniture.com' }}</li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-light mb-0" style="opacity: 0.8;">
                    &copy; {{ date('Y') }} {{ $globalSettings['site_name'] ?? 'Atta_Furniture' }}. {{ __('All Rights Reserved') }}.
                    | {{ __('Developed by') }} <a href="https://www.codessol.com/" class="text-white text-decoration-none fw-bold" target="_blank">Codessol</a>
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <p class="mb-0 fs-4 text-white">
                    <i class="fab fa-cc-visa mx-1"></i>
                    <i class="fab fa-cc-mastercard mx-1"></i>
                    <i class="fab fa-cc-paypal mx-1"></i>
                    <i class="fab fa-cc-amex mx-1"></i>
                </p>
            </div>
        </div>
    </div>
</footer>
