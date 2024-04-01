<?php

use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\SslCommerzPaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/fetch/header/cart', [FrontendController::class, 'fetchHeaderCart'])->name('fetch.header.cart');

Route::get('/about-us', [FrontendController::class, 'about'])->name('about');

Route::get('/all-category', [FrontendController::class, 'allCategory'])->name('all.category');
Route::get('/all-brand', [FrontendController::class, 'allBrand'])->name('all.brand');
Route::get('/all-flashsale', [FrontendController::class, 'allFlashsale'])->name('all.flashsale');

Route::get('/faqs', [FrontendController::class, 'faqs'])->name('faqs');

Route::get('/contact-us', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact/message/send', [FrontendController::class, 'contactMessageSend'])->name('contact.message.send');

Route::get('/page/{slug}', [FrontendController::class, 'page'])->name('page');

// Product Route
Route::get('/all-product', [FrontendController::class, 'allProduct'])->name('all.product');
Route::get('/quick/view/product/{id}', [FrontendController::class, 'quickViewProduct'])->name('quick.view.product');
Route::get('/category/{slug}', [FrontendController::class, 'categoryWiseProduct'])->name('category.wise.product');
Route::get('/subcategory/{slug}', [FrontendController::class, 'subcategoryWiseProduct'])->name('subcategory.wise.product');
Route::get('/childcategory/{slug}', [FrontendController::class, 'childcategoryWiseProduct'])->name('childcategory.wise.product');
Route::get('/brand/{slug}', [FrontendController::class, 'brandWiseProduct'])->name('brand.wise.product');
Route::get('/flashsale/{slug}', [FrontendController::class, 'flashsaleProduct'])->name('flashsale.product');
Route::get('/product-details/{slug}', [FrontendController::class, 'productDetails'])->name('product.details');
Route::post('/find/product', [FrontendController::class, 'findProduct'])->name('find.product');
Route::get('/search-products', [FrontendController::class, 'searchProducts'])->name('search.products');
Route::post('/get/sizes', [FrontendController::class, 'getSizes'])->name('get.sizes');
Route::post('/get/quantity', [FrontendController::class, 'getQuantity'])->name('get.quantity');
Route::post('/model/get/quantity', [FrontendController::class, 'modelGetQuantity'])->name('model.get.quantity');
Route::post('/product/filtering', [FrontendController::class, 'productFiltering'])->name('product.filtering');
Route::post('/product/filtering/brand', [FrontendController::class, 'productFilteringBrand'])->name('product.filtering.brand');
Route::post('/product/brand/wise/filtering', [FrontendController::class, 'productBrandWiseFiltering'])->name('product.brand.wise.filtering');

Route::get('/flashsale-product-details/{flashsaleSlug}/{productSlug}', [FrontendController::class, 'flashsaleProductDetails'])->name('flashsale.product.details');
Route::get('/quick-view-flashsale-product/{productId}/{flashsaleId}', [FrontendController::class, 'quickViewFlashsaleProduct'])->name('quick.view.flashsale.product');
// Blog Route
Route::get('/all-blog', [FrontendController::class, 'allBlog'])->name('all.blog');
Route::get('/blog_category/{slug}', [FrontendController::class, 'categoryWiseBlog'])->name('category.wise.blog');
Route::get('/blog-details/{slug}', [FrontendController::class, 'blogDetails'])->name('blog.details');
Route::post('/blog/comment/post/{id}', [FrontendController::class, 'blogCommentPost'])->name('blog.comment.post');
Route::post('/find/blog', [FrontendController::class, 'findBlog'])->name('find.blog');
Route::get('/search-blogs', [FrontendController::class, 'searchBlogs'])->name('search.blogs');

Route::get('/order-tracking', [FrontendController::class, 'orderTracking'])->name('order.tracking');
Route::post('/check/order/status', [FrontendController::class, 'checkOrderStatus'])->name('check.order.status');

Route::post('/subscribe/post', [FrontendController::class, 'subscribePost'])->name('subscribe.post');

// SSLCOMMERZ Start
Route::get('/pay', [SslCommerzPaymentController::class, 'index']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

require __DIR__.'/frontend.php';
require __DIR__.'/admin.php';
