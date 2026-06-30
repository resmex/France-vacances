<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DestinationsController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\Packages\PostController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [WelcomeController::class, 'index']);
Route::get('packages/destinations/{destination}', [PostController::class, 'show'])->name('desti.show');

Auth::routes(['verify' => true]);

Route::get('/about',      [WelcomeController::class, 'about'])->name('about');
Route::get('/packages',   [WelcomeController::class, 'packages'])->name('packages');
Route::get('/properties', [WelcomeController::class, 'packages'])->name('properties');
Route::get('/news',       [WelcomeController::class, 'blog'])->name('blog');
Route::get('/contact',    [WelcomeController::class, 'contact'])->name('contact');
Route::post('/contact',   [ContactUsController::class, 'ContactUs'])->name('contact.store');

Route::get('/regions/{region}', [WelcomeController::class, 'regionShow'])->name('regions.show');

Route::get('/cart',     [WelcomeController::class, 'cart'])->name('cart');
Route::get('/checkout', [WelcomeController::class, 'checkout'])->name('checkout');
Route::get('/Checkout', [CheckoutController::class, 'checkout'])->name('checkout.store');
Route::delete('/cart/{id}/remove', [CartController::class, 'removeItem'])->name('cart.remove');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Case study pages (public)
Route::prefix('case-study')->name('case-study.')->group(function () {
    Route::get('/',                   [CaseStudyController::class, 'index'])->name('index');
    Route::get('/system-integration', [CaseStudyController::class, 'systemIntegration'])->name('system-integration');
    Route::get('/security',           [CaseStudyController::class, 'security'])->name('security');
    Route::get('/infrastructure',     [CaseStudyController::class, 'infrastructure'])->name('infrastructure');
});

Route::group(['middleware' => ['isVerified']], function () {
    Route::get('email-verification/error', [RegisterController::class, 'getVerificationError'])->name('email-verification.error');
    Route::get('email-verification/check/{token}', [RegisterController::class, 'getVerification'])->name('email-verification.check');
});

/*
|--------------------------------------------------------------------------
| Authenticated Customer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // ── Admin dashboard (requires auth — admin check happens inside HomeController) ──
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ── Customer area ──────────────────────────────────────────────────────────
    Route::get('/account',          [CustomerController::class, 'dashboard'])->name('account.dashboard');
    Route::get('/account/profile',  [CustomerController::class, 'profile'])->name('account.profile');
    Route::put('/account/profile',  [CustomerController::class, 'updateProfile'])->name('account.profile.update');
    Route::put('/account/password', [CustomerController::class, 'updatePassword'])->name('account.password.update');

    // ── Bookings & Payment ─────────────────────────────────────────────────────
    Route::post('/packages/destinations/{destination}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings',                [BookingController::class, 'myBookings'])->name('bookings.my');
    Route::get('/payment/{booking}',          [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/payment/{booking}',         [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/booking/confirmation/{booking}', [PaymentController::class, 'confirmation'])->name('booking.confirmation');

    // ── Reviews ────────────────────────────────────────────────────────────────
    Route::post('destinations/{destination}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // ── Wishlist ───────────────────────────────────────────────────────────────
    Route::get('wishlist',                         [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('wishlist/{destination}/toggle',   [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('wishlist/{destination}',          [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('wishlist/{destination}',        [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // ── Profile (kept for navbar link compatibility) ───────────────────────────
    Route::get('users/profile', [UsersController::class, 'edit'])->name('users.edit-profile');
    Route::put('users/profile', [UsersController::class, 'update'])->name('users.update-profile');
});

/*
|--------------------------------------------------------------------------
| Admin-Only Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    // Content management
    Route::resource('categories', CategoriesController::class);
    Route::resource('destinations', DestinationsController::class);
    Route::resource('tags', TagsController::class);
    Route::resource('blog', BlogController::class);
    Route::get('trashed-destinations', [DestinationsController::class, 'trashed'])->name('trashed-destinations.index');
    Route::put('restore-destinations/{destinations}', [DestinationsController::class, 'restore'])->name('restore-destinations');

    // Users & role management
    Route::get('users',                           [UsersController::class, 'index'])->name('users.index');
    Route::post('users/{user}/make-admin',        [UsersController::class, 'makeAdmin'])->name('users.make-admin');
    Route::post('users/{user}/assign-role',       [UsersController::class, 'assignRole'])->name('users.assign-role');

    // Bookings (admin)
    Route::get('/admin/bookings',                 [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/admin/bookings/{booking}',       [BookingController::class, 'show'])->name('bookings.show');
    Route::put('/admin/bookings/{booking}/status',[BookingController::class, 'updateStatus'])->name('bookings.status');

    // Payments (admin)
    Route::get('/admin/payments',                 [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/admin/payments/{payment}',       [PaymentController::class, 'show'])->name('payments.show');

    // Reports
    Route::get('/admin/reports',                  [ReportController::class, 'index'])->name('reports.index');
});

/*
|--------------------------------------------------------------------------
| Role-Specific Portal Routes (auth + own role OR admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
});

Route::middleware(['auth', 'role:finance'])->group(function () {
    Route::get('/finance', [FinanceController::class, 'dashboard'])->name('finance.dashboard');
});

Route::middleware(['auth', 'role:it'])->group(function () {
    Route::get('/it', [ItController::class, 'dashboard'])->name('it.dashboard');
});
