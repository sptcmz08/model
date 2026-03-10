<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Middleware\AdminAuthenticate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Language Switcher Route
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'th'])) {
        Session::put('locale', $locale);
        // Also queue a cookie for 1 year
        return redirect()->back()->withCookie(cookie('locale', $locale, 60 * 24 * 365));
    }
    return redirect()->back();
})->name('lang.switch');

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send')->middleware('throttle:5,1');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Cart
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{productId}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/update/{productId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
});

// Checkout
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/', [CheckoutController::class, 'process'])->name('checkout.process')->middleware('throttle:10,1');
    Route::get('/confirm-payment/{order_number}', [CheckoutController::class, 'confirmPayment'])->name('checkout.confirm-payment');
    Route::post('/submit-slip/{order_number}', [CheckoutController::class, 'submitPaymentSlip'])->name('checkout.submit-slip');
    Route::post('/request-invoice/{order_number}', [CheckoutController::class, 'requestInvoice'])->name('checkout.request-invoice');
    Route::get('/invoice-requested/{order_number}', [CheckoutController::class, 'invoiceRequested'])->name('checkout.invoice-requested');
    Route::get('/success-manual/{order_number}', [CheckoutController::class, 'successManual'])->name('checkout.success-manual');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes (guest only) with rate limiting (5 attempts per minute)
    Route::middleware(['guest:admin', 'throttle:5,1'])->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    // Protected routes
    Route::middleware(AdminAuthenticate::class)->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', CategoryController::class);
        Route::resource('products', AdminProductController::class);
        Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
        Route::get('/about-images', [\App\Http\Controllers\Admin\AboutImageController::class, 'index'])->name('about-images.index');
        Route::post('/about-images', [\App\Http\Controllers\Admin\AboutImageController::class, 'store'])->name('about-images.store');
        Route::delete('/about-images/{about_image}', [\App\Http\Controllers\Admin\AboutImageController::class, 'destroy'])->name('about-images.destroy');
        Route::post('/shipping-rates', [\App\Http\Controllers\Admin\BannerController::class, 'updateShippingRates'])->name('shipping-rates.update');
        Route::get('/invoices', [OrderController::class, 'invoices'])->name('invoices.index');
        Route::get('/invoices/{order}', [OrderController::class, 'invoiceShow'])->name('invoices.show');
        Route::post('/invoices/{order}/send', [OrderController::class, 'sendInvoice'])->name('invoices.send');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::post('/orders/{order}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('orders.confirm-payment');
        Route::post('/orders/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
        Route::post('/orders/{order}/send-note', [OrderController::class, 'sendNote'])->name('orders.send-note');
        Route::get('/orders/{order}/receipt', [OrderController::class, 'printReceipt'])->name('orders.receipt');
        // Admin Settings
        Route::get('/settings', [AdminAuthController::class, 'showSettings'])->name('settings');
        Route::post('/settings/password', [AdminAuthController::class, 'updatePassword'])->name('settings.password');
    });
});

// Serve files via /media prefix to bypass public/storage folder conflicts
Route::get('media/{path}', function ($path) {
    // Block path traversal attacks
    if (str_contains($path, '..') || str_contains($path, '\\')) {
        abort(403);
    }

    $filePath = storage_path('app/public/' . $path);
    $realPath = realpath($filePath);
    $allowedBase = realpath(storage_path('app/public'));

    // Verify the resolved path is within the allowed directory
    if (!$realPath || !$allowedBase || !str_starts_with($realPath, $allowedBase)) {
        abort(403);
    }

    if (!file_exists($realPath)) {
        abort(404);
    }

    $mimeType = \Illuminate\Support\Facades\File::mimeType($realPath);

    // Only allow safe file types
    $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml', 'application/pdf'];
    if (!in_array($mimeType, $allowedMimes)) {
        abort(403);
    }

    return response()->file($realPath, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*');



