<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ur' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($globalSettings['site_name'] ?? 'dwakhana') . ' — Herbal & Hakimai Dawae Pakistan')</title>
    <meta name="description"
        content="{{ $globalSettings['meta_description'] ?? ($globalSettings['footer_description'] ?? 'Dwakhana - Trusted provider of hakimai dawae and herbal remedies in Pakistan. Shop authentic natural remedies with local delivery.') }}">
    <meta name="keywords"
        content="{{ $globalSettings['meta_keywords'] ?? 'dwakhana, hakimai dawae, herbal remedies, hakim medicine, Pakistan, natural medicine' }}">
    <meta name="robots" content="index, follow">

    @include('partials.hreflang')

    <!-- Open Graph -->
    <meta property="og:site_name" content="{{ $globalSettings['site_name'] ?? 'dwakhana' }}">
    <meta property="og:title" content="{{ $globalSettings['site_name'] ?? 'dwakhana' }}">
    <meta property="og:description"
        content="{{ $globalSettings['meta_description'] ?? ($globalSettings['footer_description'] ?? 'Trusted hakimai dawae in Pakistan') }}">
    @if(!empty($globalSettings['site_logo']))
        <meta property="og:image" content="{{ asset($globalSettings['site_logo']) }}">
    @endif
    <meta property="og:type" content="website">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.currencySymbol = "{{ ($globalSettings['currency_symbol'] ?? '$') . ' ' }}";
    </script>

    @if(!empty($globalSettings['site_favicon']))
        <link rel="icon" type="image/x-icon" href="{{ asset($globalSettings['site_favicon']) }}">
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    @if(app()->getLocale() == 'ur')
        <!-- Urdu uses RTL; keep bootstrap RTL but no Arabic-only font enforced -->
    @endif

    <!-- Bootstrap CSS -->
    @if(app()->getLocale() == 'ur')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    @stack('styles')
    <!-- Preload custom CSS for faster first paint -->
    <link rel="preload" href="{{ asset('css/custom.css') }}" as="style">

    @stack('seo_tags')
</head>

<body>

    <a class="visually-hidden-focusable skip-link" href="#main-content">Skip to content</a>

    @include('partials.navbar')

    <main id="main-content" role="main">
        <div class="container mt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Back to top -->
    <button class="btn btn-secondary-custom rounded-circle shadow" id="back-to-top" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>

    <!-- Custom JS (deferred) -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    @stack('scripts')
</body>

</html>