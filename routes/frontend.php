<?php

use App\Http\Controllers\Frontend\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Frontend\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Frontend\Auth\NewPasswordController;
use App\Http\Controllers\Frontend\Auth\PasswordResetLinkController;
use App\Http\Controllers\Frontend\Auth\RegisteredUserController;
use App\Http\Controllers\Frontend\Auth\VerifyEmailController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\WishlistController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');

    Route::get('/google/login/', [CustomerController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/google/login/callback', [CustomerController::class, 'handleGoogleCallback']);

    Route::get('/facebook/login/', [CustomerController::class, 'redirectToFacebook'])->name('facebook.login');
    Route::get('/facebook/login/callback', [CustomerController::class, 'handleFacebookCallback']);
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->name('verification.verify')
                ->middleware(['signed', 'throttle:6,1']);
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->name('verification.send')
                ->middleware('throttle:6,1');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::middleware('verified')->group(function () {
        Route::get('dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::post('change/profile', [CustomerController::class, 'changeProfile'])->name('change.profile');
        Route::post('change/password', [CustomerController::class, 'changePassword'])->name('change.password');

        Route::get('view-invoice/{id}', [CustomerController::class, 'viewInvoice'])->name('view.invoice');
        Route::get('download-invoice/{id}', [CustomerController::class, 'downloadInvoice'])->name('download.invoice');

        Route::get('/wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');
        Route::post('insert/wishlist', [WishlistController::class, 'insertWishlist'])->name('insert.wishlist');
        Route::get('fetch/wishlist', [WishlistController::class, 'fetchWishlist'])->name('fetch.wishlist');
        Route::get('wishlist/forcedelete/{id}', [WishlistController::class, 'wishlistForceDelete'])->name('wishlist.forcedelete');

        Route::get('/cart', [CartController::class, 'cart'])->name('cart');
        Route::post('insert/cart', [CartController::class, 'insertCart'])->name('insert.cart');
        Route::get('fetch/cart', [CartController::class, 'fetchCart'])->name('fetch.cart');
        Route::post('cart/item/inc', [CartController::class, 'cartItemInc'])->name('cart.item.inc');
        Route::post('cart/item/dec', [CartController::class, 'cartItemDec'])->name('cart.item.dec');
        Route::get('cart/forcedelete/{id}', [CartController::class, 'cartForceDelete'])->name('cart.forcedelete');
        Route::post('check/coupon', [CartController::class, 'checkCoupon'])->name('check.coupon');
        Route::get('remove/coupon', [CartController::class, 'removeCoupon'])->name('remove.coupon');
        Route::get('change/cart/status/{id}', [CartController::class, 'changeCartStatus'])->name('change.cart.status');

        Route::post('buy/now', [CartController::class, 'buyNow'])->name('buy.now');

        Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
        Route::post('get/city/list', [CheckoutController::class, 'getCityList'])->name('get.city.list');
        Route::post('set/country/city', [CheckoutController::class, 'setCountryCity'])->name('set.country.city');
        Route::post('checkout/post', [CheckoutController::class, 'checkoutPost'])->name('checkout.post');

        Route::get('later/pay/{grand_total}/{order_summery_id}', [CheckoutController::class, 'laterPay']);

        Route::get('cancel/order/{id}', [CustomerController::class, 'cancelOrder'])->name('cancel.order');

        Route::get('return-request/{id}', [CustomerController::class, 'returnRequest'])->name('return.request');
        Route::post('order/return/post/{id}', [CustomerController::class, 'orderReturnPost'])->name('order.return.post');

        Route::get('order-review/{id}', [CustomerController::class, 'orderReview'])->name('order.review');
        Route::post('order/review/post/{id}', [CustomerController::class, 'orderReviewPost'])->name('order.review.post');
    });
});
