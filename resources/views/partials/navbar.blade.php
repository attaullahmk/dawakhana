<header class="bg-white header-top">
    @php
        $cartCount = auth()->check() ? \App\Models\Cart::where('user_id', auth()->id())->count() : \App\Models\Cart::where('session_id', session()->getId())->count();
    @endphp
    <!-- Top Header -->
    <div class="container py-2 py-md-4">
        <div class="d-flex align-items-center justify-content-between flex-nowrap w-100">
            <!-- Mobile Toggle & Logo -->
            <div class="d-flex align-items-center flex-shrink-0">
                <button class="btn border-0 d-lg-none ps-0 me-1 pe-2" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                    <i class="fas fa-bars fs-4 text-primary-custom"></i>
                </button>
                <a class="navbar-brand text-dark fw-bold text-decoration-none d-flex align-items-center gap-1 gap-md-2"
                    href="{{ route('home') }}">
                    <img src="{{ asset('storage/settings/XxkHVaHPreip4SouIaDyPcSwyqTbick49TKyBP22.jpg') }}"
                        loading="lazy" alt="Logo" style="max-height: 35px;" class="me-0">
                    <span class="text-primary-custom"
                        style="font-family: 'Playfair Display', serif; letter-spacing: -0.5px; font-size: 1.25rem;">{{ $globalSettings['site_name'] ?? 'dwakhana' }}</span>
                </a>
            </div>

            <!-- Search Bar (Hidden on Mobile) -->
            <div class="d-none d-lg-block flex-grow-1 mx-3 mx-xl-4">
                <form action="{{ route('shop.index') }}" method="GET" id="header-search-form">
                    @php
                        $rawCategory = request('category');
                        $selectedCategory = is_array($rawCategory) ? ($rawCategory[0] ?? '') : $rawCategory;
                    @endphp
                    <input type="hidden" name="category" id="header-cat-input" value="{{ $selectedCategory }}">
                    <div class="input-group search-group shadow-none border rounded-1 bg-white"
                        style="border-width: 1px !important; border-color: var(--primary) !important;">
                        <!-- Custom Select Dropdown -->
                        <div class="dropdown border-end d-flex align-items-center">
                            @php
                                $currentCatName = __('All categories');
                                if ($selectedCategory) {
                                    $currentCat = $globalCategories->where('slug', $selectedCategory)->first();
                                    if ($currentCat)
                                        $currentCatName = $currentCat->name;
                                }
                            @endphp
                            <button
                                class="btn border-0 shadow-none text-muted dropdown-toggle d-flex align-items-center justify-content-between px-3 text-truncate"
                                id="header-cat-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                style="width: 160px; font-size: 0.9rem; background: transparent;">
                                <span>{{ $currentCatName }}</span>
                            </button>
                            <ul class="dropdown-menu border-0 shadow-lg p-2 custom-category-dropdown"
                                style="width: 260px; max-height: 350px; overflow-y: auto; border-radius: 8px; z-index: 1060;">
                                <li><a class="dropdown-item text-muted py-2 px-3 rounded mb-1 category-item-header"
                                        href="#" data-slug="" style="font-size: 0.95rem;">{{ __('All categories') }}</a>
                                </li>
                                @foreach($globalCategories as $cat)
                                    <li>
                                        <a class="dropdown-item text-muted py-2 px-3 rounded mb-1 category-item-header"
                                            href="#" data-slug="{{ $cat->slug }}" style="font-size: 0.95rem;">
                                            {{ $cat->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <input type="text" name="q" value="{{ request('q') }}"
                            class="form-control border-0 shadow-none ps-3"
                            placeholder="{{ __('Search for products, categories or brands...') }}"
                            style="font-size: 0.9rem; background: transparent;">
                        <button class="btn border-0 px-4 bg-primary-custom text-white rounded-0" type="submit"><i
                                class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <!-- Right Icons -->
            <div class="d-flex justify-content-end align-items-center gap-2 gap-md-3 flex-shrink-0">
                <!-- Language Switcher -->
                <div class="dropdown me-0 me-md-1">
                    <button class="btn btn-link text-decoration-none text-dark p-0 p-md-1 dropdown-toggle no-caret"
                        type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-globe text-muted"></i><span
                            class="text-uppercase small fw-bold text-muted ms-1" style="font-size: 0.75rem;">{{ app()->getLocale() }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm p-1" style="min-width: 130px;">
                        <li><a class="dropdown-item py-1 px-3 rounded {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                                href="{{ route('lang.switch', 'en') }}">🇬🇧 English</a></li>
                        <!-- Arabic removed: only English and Urdu supported -->
                        <li><a class="dropdown-item py-1 px-3 rounded {{ app()->getLocale() == 'ur' ? 'active' : '' }}"
                                href="{{ route('lang.switch', 'ur') }}">🇵🇰 اردو</a></li>
                    </ul>
                </div>

                <!-- Mobile Search Toggle -->
                <button class="btn border-0 d-lg-none p-0 text-muted" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mobileSearch" aria-expanded="false">
                    <i class="fas fa-search fs-5"></i>
                </button>

                @guest
                    <a href="{{ route('login') }}"
                        class="text-dark text-decoration-none d-flex align-items-center gap-1 hover-primary ps-1">
                        <div class="position-relative">
                            <i class="far fa-heart fs-5 text-muted"></i>
                        </div>
                    </a>
                @endguest

                @auth
                    <a href="{{ route('wishlist.index') }}"
                        class="text-dark text-decoration-none d-flex align-items-center gap-1 hover-primary ps-1">
                        <div class="position-relative">
                            <i class="far fa-heart fs-5 text-muted"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary-custom wishlist-count-badge"
                                style="font-size: 0.6em; margin-top: 5px;">{{ auth()->user()->wishlists()->count() }}</span>
                        </div>
                    </a>

                    <div class="dropdown">
                        <a href="#"
                            class="text-dark text-decoration-none d-flex align-items-center gap-1 hover-primary dropdown-toggle no-caret"
                            data-bs-toggle="dropdown">
                            <i class="far fa-user fs-5 text-muted"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2"
                            style="border-radius: 12px; min-width: 180px; z-index: 1100;">
                            <li><a class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 rounded mb-1"
                                    href="{{ route('account.index') }}"><i class="fas fa-user-circle text-muted"></i>
                                    {{ __('Profile') }}</a></li>
                            @if(auth()->user()->isAdmin())
                                <li><a class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 rounded mb-1"
                                        href="{{ route('admin.dashboard') }}"><i class="fas fa-user-shield text-muted"></i>
                                        {{ __('Admin Panel') }}</a></li>
                            @endif
                            <li>
                                <hr class="dropdown-divider my-2">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="px-2">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-danger btn-sm w-100 rounded-pill py-2">{{ __('Logout') }}</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth

                <a href="{{ route('cart.index') }}"
                    class="text-dark text-decoration-none d-flex align-items-center gap-1 hover-primary ps-1"
                    id="cart-nav-link">
                    <div class="position-relative">
                        <i class="fas fa-shopping-cart fs-5 text-muted"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary-custom cart-count-badge"
                            style="font-size: 0.6em; margin-top: 5px;">{{ $cartCount }}</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Mobile Search (Collapsible) -->
        <div class="collapse d-lg-none mt-2" id="mobileSearch">
            <form action="{{ route('shop.index') }}" method="GET" class="pb-3 px-1">
                <div class="input-group search-group shadow-none border rounded-pill bg-white overflow-hidden"
                    style="border-width: 1px !important; border-color: var(--primary) !important;">
                    <input type="text" name="q" value="{{ request('q') }}"
                        class="form-control border-0 shadow-none ps-3 py-2"
                        placeholder="{{ __('Search furniture...') }}" style="font-size: 0.85rem;">
                    <button class="btn border-0 px-3 bg-primary-custom text-white" type="submit"><i
                            class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
</header>

<!-- Mobile Offcanvas Menu -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel"
    style="width: 300px;">
    <div class="offcanvas-header border-bottom py-4">
        <h5 class="offcanvas-title fw-bold text-primary-custom" id="mobileMenuLabel">
            {{ $globalSettings['site_name'] ?? 'Atta_Furniture' }}</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column p-0">
        <div class="list-group list-group-flush">
            <a href="{{ route('home') }}"
                class="list-group-item list-group-item-action py-3 border-0 px-4 fw-medium {{ request()->routeIs('home') ? 'bg-light text-primary-custom' : '' }}">{{ __('Home') }}</a>

            <!-- Mobile Categories (Collapsible) -->
            <div class="list-group-item p-0 border-0">
                <a class="list-group-item list-group-item-action py-3 border-0 px-4 fw-medium d-flex align-items-center justify-content-between"
                    data-bs-toggle="collapse" href="#mobileCats">
                    {{ __('Categories') }} <i class="fas fa-chevron-down small text-muted"></i>
                </a>
                <div class="collapse bg-light" id="mobileCats">
                    @foreach($globalCategories as $cat)
                        <a href="{{ route('shop.index', ['category' => $cat->slug]) }}"
                            class="list-group-item list-group-item-action py-2 border-0 ps-5 small text-muted">{{ $cat->name }}</a>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('shop.index') }}"
                class="list-group-item list-group-item-action py-3 border-0 px-4 fw-medium {{ request()->routeIs('shop.index') ? 'bg-light text-primary-custom' : '' }}">{{ __('Shop') }}</a>
            <a href="{{ route('about') }}"
                class="list-group-item list-group-item-action py-3 border-0 px-4 fw-medium {{ request()->routeIs('about') ? 'bg-light text-primary-custom' : '' }}">{{ __('About') }}</a>
            <a href="{{ route('blog.index') }}"
                class="list-group-item list-group-item-action py-3 border-0 px-4 fw-medium {{ request()->routeIs('blog.index') ? 'bg-light text-primary-custom' : '' }}">{{ __('Blog') }}</a>
            <a href="{{ route('contact') }}"
                class="list-group-item list-group-item-action py-3 border-0 px-4 fw-medium {{ request()->routeIs('contact') ? 'bg-light text-primary-custom' : '' }}">{{ __('Contact') }}</a>
        </div>

        <div class="p-4 mt-auto border-top">
            <div class="small text-muted mb-2">{{ __('Need Help?') }}</div>
            <div class="fw-bold text-primary-custom fs-5 mb-3">{{ $globalSettings['site_phone'] ?? '+(2) 871 382 023' }}
            </div>
            <div class="mb-3">
                <p class="text-muted mb-0 small">
                    {{ __('Developed by') }} <a href="https://www.codessol.com/"
                        class="text-primary-custom text-decoration-none fw-bold" target="_blank">Codessol</a>
                </p>
            </div>
            <div class="d-flex gap-3">
                <a href="#" class="text-muted fs-5"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-muted fs-5"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-muted fs-5"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const headerCatItems = document.querySelectorAll('.category-item-header');
        const headerCatInput = document.getElementById('header-cat-input');
        const headerCatBtn = document.getElementById('header-cat-btn');

        headerCatItems.forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                const slug = this.getAttribute('data-slug');
                const name = this.innerText;

                headerCatInput.value = slug;
                headerCatBtn.querySelector('span').innerText = name;
            });
        });
    });
</script>

<!-- Navigation Bar (Sticky for Desktop only) -->
<div class="border-top border-bottom py-0 bg-white sticky-top shadow-sm w-100 d-none d-lg-block"
    style="z-index: 1050; top: 0;">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-stretch">
            <!-- Dropdown Categories button -->
            <div class="dropdown h-100 d-flex category-dropdown">
                <button
                    class="btn px-4 fw-bold text-white rounded-0 h-100 border-0 d-flex align-items-center gap-2 py-3 bg-primary-custom"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-th-large"></i> {{ __('Browse Categories') }} <i
                        class="fas fa-chevron-down ms-2 small" style="font-size: 0.7em;"></i>
                </button>
                <ul class="dropdown-menu border-0 shadow-lg mt-0 rounded-bottom p-2"
                    style="min-width: 280px; border-top: 3px solid var(--primary) !important;">
                    @foreach($globalCategories->take(5) as $cat)
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-3 py-2 px-3 mb-1 rounded hover-bg-light"
                                href="{{ route('shop.index', ['category' => $cat->slug]) }}">
                                <div class="d-flex align-items-center justify-content-center rounded overflow-hidden"
                                    style="width: 42px; height: 42px; background-color: rgba(92, 61, 46, 0.1); color: var(--primary);">
                                    @if($cat->image)
                                        <img src="{{ asset($cat->image) }}" class="w-100 h-100 object-fit-cover"
                                            alt="{{ $cat->name }}">
                                    @else
                                        <i class="fas fa-folder fs-5"></i>
                                    @endif
                                </div>
                                <div class="fw-semibold text-dark">{{ $cat->name }}</div>
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <hr class="dropdown-divider my-2">
                    </li>
                    <li>
                        <a class="dropdown-item text-center fw-bold py-2 text-primary-custom"
                            href="{{ route('shop.index') }}">{{ __('View All Categories') }} <i
                                class="fas fa-arrow-right ms-1"></i></a>
                    </li>
                </ul>
            </div>

            <nav class="d-none d-lg-flex align-items-center ms-5 px-3" style="gap: 2.5rem;">
                <a href="{{ route('home') }}"
                    class="text-dark text-decoration-none fw-semibold py-3 d-flex align-items-center"
                    style="font-size: 0.95rem;">{{ __('Home') }}</a>
                <a href="{{ route('shop.index') }}"
                    class="text-dark text-decoration-none fw-semibold py-3 d-flex align-items-center"
                    style="font-size: 0.95rem;">{{ __('Shop') }}</a>
                <a href="{{ route('about') }}"
                    class="text-dark text-decoration-none fw-semibold py-3 d-flex align-items-center"
                    style="font-size: 0.95rem;">{{ __('About') }}</a>
                <a href="{{ route('blog.index') }}"
                    class="text-dark text-decoration-none fw-semibold py-3 d-flex align-items-center"
                    style="font-size: 0.95rem;">{{ __('Blog') }}</a>
                <a href="{{ route('contact') }}"
                    class="text-dark text-decoration-none fw-semibold py-3 d-flex align-items-center"
                    style="font-size: 0.95rem;">{{ __('Contact') }}</a>
            </nav>
        </div>

        <div class="d-none d-xl-flex align-items-center gap-3">
            <i class="fas fa-mobile-alt fs-3 text-secondary-custom"></i>
            <div class="lh-sm">
                <div class="text-dark" style="font-size: 0.85rem;">{{ __('Need any Help? Call Us') }}</div>
                <div class="fw-bold text-primary-custom" style="font-size: 0.95rem;">
                    {{ $globalSettings['site_phone'] ?? '+(2) 871 382 023' }}</div>
            </div>
        </div>
    </div>
</div>