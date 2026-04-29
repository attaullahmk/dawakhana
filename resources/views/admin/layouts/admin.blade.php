<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ur' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $globalSettings['site_name'] ?? 'FurniCraft' }} Admin</title>

    @if(!empty($globalSettings['site_favicon']))
        <link rel="icon" type="image/x-icon" href="{{ asset($globalSettings['site_favicon']) }}">
    @endif
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @if(app()->getLocale() == 'ur')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
        <!-- No Arabic-only font enforced; Urdu support via default fonts or custom CSS if needed -->
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --primary: #5C3D2E;
            --secondary: #D4A853;
        }
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0; 
            {{ app()->getLocale() == 'ur' ? 'right: 0;' : 'left: 0;' }}
            background-color: var(--primary);
            color: white;
            z-index: 1055;
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
        }
        .main-content {
            {{ app()->getLocale() == 'ur' ? 'margin-right: var(--sidebar-width);' : 'margin-left: var(--sidebar-width);' }}
            min-height: 100vh;
        }
        
        @if(app()->getLocale() == 'ur')
        /* Urdu-specific RTL adjustments */
        .nav-link i { margin-right: 0 !important; margin-left: 12px !important; }
        @endif
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.55);
            z-index: 1045;
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.show {
            display: block;
        }

        /* Nav Links */
        .nav-link { color: rgba(255,255,255,0.7); padding: 12px 20px; transition: all 0.2s; border-radius: 8px; margin: 0 12px 4px; display: flex; align-items: center; }
        .nav-link:hover, .nav-link.active { color: white; background-color: rgba(255,255,255,0.1); }
        .nav-link i { width: 24px; text-align: center; margin-right: 12px; font-size: 1.1rem; }
        
        .topbar { 
            background: white; 
            padding: 12px 25px; 
            box-shadow: 0 2px 15px rgba(0,0,0,0.04); 
            border-bottom: 1px solid #edf2f9;
        }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05); border-radius: 15px; }

        /* Responsive Breakpoints */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: {{ app()->getLocale() == 'ur' ? 'translateX(100%)' : 'translateX(-100%)' }};
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                {{ app()->getLocale() == 'ur' ? 'margin-right: 0;' : 'margin-left: 0;' }}
            }
            .topbar {
                padding: 12px 15px;
            }
        }

        /* Scrollbar styles */
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar py-4 shadow-lg" id="sidebar">
        <div class="d-flex align-items-center mb-5 px-4">
            <div class="flex-grow-1 text-center">
                @if(!empty($globalSettings['site_logo']))
                    <img src="{{ asset($globalSettings['site_logo']) }}" alt="{{ $globalSettings['site_name'] ?? 'Atta_Furniture' }}" class="mb-2" style="max-height: 45px; background: white; padding: 4px; border-radius: 4px;">
                @else
                    <h4 class="fw-bold mb-0 text-white" style="font-family: 'Playfair Display', serif;">{{ $globalSettings['site_name'] ?? 'Atta_Furniture' }}</h4>
                @endif
                <p class="text-white-50 small text-uppercase fw-bold mt-1 mb-0" style="letter-spacing: 1px; font-size: 0.65rem;">{{ __('Admin Control') }}</p>
            </div>
            <button class="btn border-0 text-white d-lg-none p-2 shadow-none" id="closeSidebar" style="z-index: 1100;">
                <i class="fas fa-times fs-4"></i>
            </button>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-th-large"></i> {{ __('Dashboard') }}
                </a>
            </li>
            <li class="nav-item mt-3 mb-1 px-4 small text-uppercase text-white-50 fw-bold" style="font-size: 0.7rem;">{{ __('E-Commerce') }}</li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-shopping-bag"></i> {{ __('Orders') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                    <i class="fas fa-couch"></i> {{ __('Products') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-layer-group"></i> {{ __('Categories') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}" href="{{ route('admin.coupons.index') }}">
                    <i class="fas fa-percentage"></i> {{ __('Coupons') }}
                </a>
            </li>
            
            <li class="nav-item mt-3 mb-1 px-4 small text-uppercase text-white-50 fw-bold" style="font-size: 0.7rem;">{{ __('Content') }}</li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/blog*') && !request()->is('admin/blog-categories*') ? 'active' : '' }}" href="{{ route('admin.blog.index') }}">
                    <i class="fas fa-newspaper"></i> {{ __('Blog Posts') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}" href="{{ route('admin.blog-categories.index') }}">
                    <i class="fas fa-list-ul"></i> {{ __('Blog Categories') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}">
                    <i class="fas fa-bullhorn"></i> {{ __('Banners') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.about-section.*') ? 'active' : '' }}" href="{{ route('admin.about-section.index') }}">
                    <i class="fas fa-info-circle"></i> {{ __('About Page') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">
                    <i class="fas fa-file-alt"></i> {{ __('Manage Pages') }}
                </a>
            </li>

            <li class="nav-item mt-3 mb-1 px-4 small text-uppercase text-white-50 fw-bold" style="font-size: 0.7rem;">{{ __('System') }}</li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-user-friends"></i> {{ __('Customers') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}" href="{{ route('admin.subscribers.index') }}">
                    <i class="fas fa-paper-plane"></i> {{ __('Subscribers') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.super-admins.*') ? 'active' : '' }}" href="{{ route('admin.super-admins.index') }}">
                    <i class="fas fa-user-shield"></i> {{ __('Staff') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" href="{{ route('admin.reviews.index') }}">
                    <i class="fas fa-star-half-alt"></i> {{ __('Reviews') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">
                    <i class="fas fa-comments"></i> {{ __('Messages') }}
                </a>
            </li>

            <li class="nav-item mt-3">
                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                    <i class="fas fa-sliders-h"></i> {{ __('Site Settings') }}
                </a>
            </li>

            <li class="nav-item mt-5 pt-3 border-top border-white border-opacity-10">
                <a class="nav-link text-warning" href="{{ route('home') }}" target="_blank">
                    <i class="fas fa-external-link-alt"></i> {{ __('View Store') }}
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar d-flex justify-content-between align-items-center sticky-top z-1">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary border-0 d-lg-none p-2 shadow-none" id="sidebarToggle">
                    <i class="fas fa-bars fs-4"></i>
                </button>
                <h4 class="mb-0 fw-bold text-dark d-none d-sm-block">@yield('header', __('Dashboard'))</h4>
            </div>
            
            <div class="d-flex align-items-center gap-2 gap-md-3">
                <!-- Language Switcher -->
                <div class="dropdown me-2">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle no-caret px-2" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-globe me-1"></i> <span class="text-uppercase">{{ app()->getLocale() }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2" style="border-radius: 12px;">
                        <li><a class="dropdown-item py-2 px-3 rounded mb-1 {{ app()->getLocale() == 'en' ? 'active shadow-sm' : '' }}" href="{{ route('lang.switch', 'en') }}">🇬🇧 English</a></li>
                        <li><a class="dropdown-item py-2 px-3 rounded mb-1 {{ app()->getLocale() == 'ur' ? 'active shadow-sm' : '' }}" href="{{ route('lang.switch', 'ur') }}">🇵🇰 اردو</a></li>
                    </ul>
                </div>
                
                <div class="position-relative d-none d-md-block me-2">
                    <i class="far fa-bell fs-5 text-muted"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                </div>
                <div class="d-flex align-items-center ms-md-2">
                    <div class="text-end d-none d-lg-block me-3 lh-1">
                        <div class="fw-bold small">{{ auth()->user()->name ?? __('Administrator') }}</div>
                        <small class="text-muted" style="font-size: 0.75rem;">{{ __('Super Admin') }}</small>
                    </div>
                    <div class="dropdown">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? __('Admin')) }}&background=5C3D2E&color=fff" 
                             class="rounded-circle cursor-pointer border" width="40" height="40" alt="{{ __('Admin') }}" data-bs-toggle="dropdown">
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2" style="border-radius: 12px; min-width: 180px;">
                            <li class="d-lg-none px-3 py-2 border-bottom mb-2">
                                <div class="fw-bold">{{ auth()->user()->name ?? __('Admin') }}</div>
                                <small class="text-muted">{{ __('Super Admin') }}</small>
                            </li>
                            <li><a class="dropdown-item py-2 px-3 rounded mb-1" href="{{ route('admin.super-admins.index') }}"><i class="fas fa-user-circle me-2"></i> {{ __('Profile') }}</a></li>
                            <li><a class="dropdown-item py-2 px-3 rounded mb-1" href="{{ route('admin.settings.index') }}"><i class="fas fa-cog me-2"></i> {{ __('Settings') }}</a></li>
                            <li><hr class="dropdown-divider my-2"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 px-3 rounded text-danger"><i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Body -->
        <div class="p-3 p-md-4">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            const close = document.getElementById('closeSidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (!sidebar || !overlay) {
                console.warn('Sidebar or Overlay elements not found');
                return;
            }

            function openSidebar() {
                sidebar.classList.add('show');
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }

            function toggleSidebar() {
                if (sidebar.classList.contains('show')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            }

            // Universal toggler for the menu button
            if(toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            // Explicit close actions
            [close, overlay].forEach(el => {
                if(el) {
                    el.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        closeSidebar();
                    });
                    // For mobile response improvement
                    el.addEventListener('touchstart', function(e) {
                        // We don't preventDefault here to allow scrolling if needed, 
                        // but sidebar items are usually quick taps
                    }, {passive: true});
                }
            });

            // Close sidebar when clicking links on mobile
            document.querySelectorAll('#sidebar .nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 992) {
                        closeSidebar();
                    }
                });
            });

            // Password Visibility Toggle
            document.querySelectorAll('[data-toggle-password]').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-toggle-password');
                    const passwordInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');
                    
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.replace('fa-eye', 'fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.replace('fa-eye-slash', 'fa-eye');
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
