<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitemapController;

// Public Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\LanguageController;

// Deployment Fix Route for Hostinger (Access once, then DELETE)
Route::get('/deploy-fix', function() {
    try {
        // 1. Clear all caches
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $output = "Cache cleared successfully.\n";

        // 2. Fix storage link
        $target = storage_path('app/public');
        $link = public_path('storage');

        if (file_exists($link)) {
            if (is_link($link)) {
                $output .= "Storage link already exists.\n";
            } else {
                $output .= "A folder named 'storage' exists. Please delete it first.\n";
            }
        } else {
            try {
                // Try the standard Laravel command first on all platforms
                \Illuminate\Support\Facades\Artisan::call('storage:link');
                $output .= "Storage link command executed.\n";
            } catch (\Exception $e) {
                // If Artisan fails, try manual methods
                if (function_exists('symlink')) {
                    symlink($target, $link);
                    $output .= "Storage link created via symlink function.\n";
                } elseif (function_exists('shell_exec')) {
                    shell_exec("ln -s $target $link");
                    $output .= "Storage link created via shell_exec.\n";
                } else {
                    throw new \Exception("Both symlink() and shell_exec() are disabled on your server. Please enable 'symlink' in your Hostinger PHP Configuration / PHP Functions.");
                }
            }
        }
        return "<pre>$output</pre><br><a href='/'>Go to Home</a>";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriberController;
use App\Http\Controllers\Admin\AboutSectionController as AdminAboutSectionController;

// ---------------------------------------------------------
// PUBLIC ROUTES
// ---------------------------------------------------------


Route::get('lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon/apply', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('pages.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('subscribe');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/register/verify', [AuthController::class, 'showOtpVerification'])->name('register.verify.show');
    Route::post('/register/verify', [AuthController::class, 'verifyOtp'])->name('register.verify');
    Route::post('/register/resend-otp', [AuthController::class, 'resendOtp'])->name('register.resend');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
    Route::get('/order-success', [CheckoutController::class, 'success'])->name('checkout.success');
    
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/account/update', [AccountController::class, 'updateProfile'])->name('account.update');
    
    Route::post('/product/{id}/review', [ProductController::class, 'storeReview'])->name('review.store');
});

// ---------------------------------------------------------
// ADMIN ROUTES (Protected by Admin Middleware)
// ---------------------------------------------------------

Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Login Routes (Public within prefix)
    Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);

    // Protected Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('/', function() {
            return redirect()->route('admin.dashboard');
        });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::controller(AdminProductController::class)->prefix('products')->name('products.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::delete('/image/{id}', 'destroyImage')->name('images.destroy');
    });
    
    // Categories
    Route::controller(AdminCategoryController::class)->prefix('categories')->name('categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    
    // Orders
    Route::controller(AdminOrderController::class)->prefix('orders')->name('orders.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}/status', 'updateStatus')->name('status');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    
    // Users
    Route::controller(AdminUserController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    
    // Blog
    Route::controller(AdminBlogController::class)->prefix('blog')->name('blog.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::controller(\App\Http\Controllers\Admin\BlogCategoryController::class)->prefix('blog-categories')->name('blog-categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    
    // Reviews
    Route::controller(AdminReviewController::class)->prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/{id}/toggle', 'toggleApproval')->name('toggle');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    
    // Coupons
    Route::controller(AdminCouponController::class)->prefix('coupons')->name('coupons.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    
    // Messages
    Route::controller(AdminMessageController::class)->prefix('messages')->name('messages.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    
    // Banners
    Route::controller(AdminBannerController::class)->prefix('banners')->name('banners.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // About Section
    Route::controller(AdminAboutSectionController::class)->prefix('about-section')->name('about-section.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'update')->name('update');
    });
    
    // Super Admins Management
    Route::controller(\App\Http\Controllers\Admin\SuperAdminController::class)->prefix('super-admins')->name('super-admins.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // Subscribers
    Route::controller(AdminSubscriberController::class)->prefix('subscribers')->name('subscribers.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Pages CRUD
    Route::controller(\App\Http\Controllers\Admin\PageController::class)->prefix('pages')->name('pages.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    });
});
