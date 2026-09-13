<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminAdviceController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminEducationalController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\AdviceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EducationalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/educational', [EducationalController::class, 'index'])->name('educational.index');
Route::get('/educational/{educationalContent:slug}', [EducationalController::class, 'show'])->name('educational.show');
Route::get('/advices', [AdviceController::class, 'index'])->name('advices.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');
Route::view('/privacy-policy', 'pages.privacy')->name('privacy');

/*
|--------------------------------------------------------------------------
| Guest / Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendOtp'])->name('password.email');

    Route::get('/verify-otp', [PasswordResetController::class, 'showVerifyOtpForm'])->name('password.verify');
    Route::post('/verify-otp', [PasswordResetController::class, 'verifyOtp'])->name('password.verify.post');
    Route::post('/resend-otp', [PasswordResetController::class, 'resendOtp'])->name('password.resend');

    Route::get('/reset-password', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile & Child Information
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Orders & Tracking
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/notes', [OrderController::class, 'storeNote'])->name('orders.notes.store');
    Route::post('/orders/{order}/review', [OrderController::class, 'storeReview'])->name('orders.reviews.store');

    // Checkout Stepper & Payment
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout/validate-coupon', [CheckoutController::class, 'validateCoupon'])->name('checkout.validate-coupon');
});

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Orders Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::put('/orders/{order}/plan', [AdminOrderController::class, 'updatePlan'])->name('orders.update-plan');
    Route::post('/orders/{order}/notes', [AdminOrderController::class, 'storeNote'])->name('orders.notes.store');
    Route::post('/orders/{order}/attachments', [AdminOrderController::class, 'storeAttachment'])->name('orders.attachments.store');
    Route::delete('/orders/{order}/attachments/{attachment}', [AdminOrderController::class, 'destroyAttachment'])->name('orders.attachments.destroy');

    // Services CRUD
    Route::resource('services', AdminServiceController::class);

    // Educational Content CRUD
    Route::resource('educational', AdminEducationalController::class);

    // Advices & Video Tips
    Route::get('/advices', [AdminAdviceController::class, 'index'])->name('advices.index');
    Route::get('/advices/create', [AdminAdviceController::class, 'create'])->name('advices.create');
    Route::post('/advices', [AdminAdviceController::class, 'store'])->name('advices.store');
    Route::delete('/advices/{advice}', [AdminAdviceController::class, 'destroy'])->name('advices.destroy');

    // Contact Messages
    Route::get('/contact', [AdminContactController::class, 'index'])->name('contact.index');
    Route::patch('/contact/{message}/read', [AdminContactController::class, 'markRead'])->name('contact.mark-read');
    Route::delete('/contact/{message}', [AdminContactController::class, 'destroy'])->name('contact.destroy');

    // Coupons Management
    Route::get('/coupons', [AdminCouponController::class, 'index'])->name('coupons.index');
    Route::post('/coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
    Route::delete('/coupons/{coupon}', [AdminCouponController::class, 'destroy'])->name('coupons.destroy');
});
