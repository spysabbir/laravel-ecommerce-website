<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\Blog_categoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChildcategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\FlashsaleController;
use App\Http\Controllers\Admin\Order_Controller;
use App\Http\Controllers\Admin\Page_settingController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
    });

    Route::middleware('admin_auth')->group(function () {
        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('profile', [AdminController::class, 'profile'])->name('profile');
        Route::post('change/profile', [AdminController::class, 'changeProfile'])->name('change.profile');
        Route::post('change/password', [AdminController::class, 'changePassword'])  ->name('change.password');
    });
});

//
Route::prefix('admin')->middleware(['admin_auth'])->group(function () {
    Route::middleware(['super_admin'])->group(function(){
        // Setting
        Route::get('/mail-setting', [SettingController::class, 'mailSetting'])->name('mail.setting');
        Route::post('/mail/setting/update/{id}', [SettingController::class, 'mailSettingUpdate'])->name('mail.setting.update');

        Route::get('/default-setting', [SettingController::class, 'defaultSetting'])->name('default.setting');
        Route::post('/default/setting/update/{id}', [SettingController::class, 'defaultSettingUpdate'])->name('default.setting.update');

        Route::get('/payment-setting', [SettingController::class, 'paymentSetting'])->name('payment.setting');
        Route::post('/payment/setting/update/{id}', [SettingController::class, 'paymentSettingUpdate'])->name('payment.setting.update');

        Route::get('/social-login-setting', [SettingController::class, 'socialLoginSetting'])->name('social-login.setting');
        Route::post('/social/login/setting/update/{id}', [SettingController::class, 'socialLoginSettingUpdate'])->name('social-login.setting.update');

        Route::get('/seo-setting', [SettingController::class, 'seoSetting'])->name('seo.setting');
        Route::post('/seo/setting/update/{id}', [SettingController::class, 'seoSettingUpdate'])->name('seo.setting.update');

        Route::get('/sms-setting', [SettingController::class, 'smsSetting'])->name('sms.setting');
        Route::post('/sms/setting/update/{id}', [SettingController::class, 'smsSettingUpdate'])->name('sms.setting.update');

        Route::resource('page-setting', Page_settingController::class);
        Route::get('/page/setting/restore/{id}', [Page_settingController::class, 'pageSettingRestore'])->name('page-setting.restore');
        Route::get('/page/setting/forcedelete/{id}', [Page_settingController::class, 'pageSettingForceDelete'])->name('page-setting.forcedelete');
        Route::get('/page/setting/status/{id}', [Page_settingController::class, 'pageSettingStatus'])->name('page-setting.status');

        // All Customer
        Route::get('all-customer', [AdminController::class, 'allCustomer'])->name('all.customer');
        Route::get('customer-details/{id}', [AdminController::class, 'customerDetails'])->name('customer.details');
        Route::get('customer/status/{id}', [AdminController::class, 'customerStatus'])->name('customer.status');

        // All Administration
        Route::get('register', [RegisteredUserController::class, 'create'])->name('administration.register');
        Route::post('register', [RegisteredUserController::class, 'store']);

        Route::get('all-administration', [AdminController::class, 'allAdministration'])->name('all.administration');
        Route::get('administration-details/{id}', [AdminController::class, 'administrationDetails'])->name('administration.details');
        Route::get('administration-edit/{id}', [AdminController::class, 'administrationEdit'])->name('administration.edit');
        Route::put('administration-update/{id}', [AdminController::class, 'administrationUpdate'])->name('administration.update');
        Route::get('administration/status/{id}', [AdminController::class, 'administrationStatus'])->name('administration.status');

        // All Subscriber
        Route::get('all-subscriber', [AdminController::class, 'allSubscriber'])->name('all.subscriber');
        Route::get('subscriber/status/{id}', [AdminController::class, 'subscriberStatus'])->name('subscriber.status');
        Route::delete('subscriber/destroy/{id}', [AdminController::class, 'subscriberDestroy'])->name('subscriber.destroy');
        Route::get('all-newsletter', [AdminController::class, 'allNewsletter'])->name('all.newsletter');
        Route::post('send-newsletter', [AdminController::class, 'sendNewsletter'])->name('send.newsletter');
        Route::get('view-newsletter/{id}', [AdminController::class, 'viewNewsletter'])->name('view.newsletter');

        // Contact Message
        Route::get('contact-message', [AdminController::class, 'contactMessage'])->name('contact.message');
        Route::get('contact-message-details/{id}', [AdminController::class, 'contactMessageDetails'])->name('contact.message.details');
        Route::delete('contact/message/destroy/{id}', [AdminController::class, 'contactMessageDestroy'])->name('contact.message.destroy');

        // Report
        Route::get('report-all-order', [ReportController::class, 'reportAllOrder'])->name('report.all.order');
        Route::get('report/all/order/print', [ReportController::class, 'reportAllOrderPrint'])->name('report.all.order.print');
        Route::post('report/all/order/export', [ReportController::class, 'reportAllOrderExport'])->name('report.all.order.export');

        Route::get('report-product-inventory', [ReportController::class, 'reportProductInventory'])->name('report.product.inventory');
        Route::get('report/product/inventory/print', [ReportController::class, 'reportProductInventoryPrint'])->name('report.product.inventory.print');
        Route::post('report/product/inventory/export', [ReportController::class, 'reportProductInventoryExport'])->name('report.product.inventory.export');
    });

    Route::middleware(['admin'])->group(function () {
        // Product Resource
        Route::resource('category', CategoryController::class);
        Route::get('/fetch/trashed/category', [CategoryController::class, 'fetchTrashedCategory'])->name('fetch.trashed.category');
        Route::get('/category/restore/{id}', [CategoryController::class, 'categoryRestore'])->name('category.restore');
        Route::get('/category/forcedelete/{id}', [CategoryController::class, 'categoryForceDelete'])->name('category.forcedelete');
        Route::get('/category/status/{id}', [CategoryController::class, 'categoryStatus'])->name('category.status');
        Route::get('/category/show/home/screen/{id}', [CategoryController::class, 'categoryShowHomeScreen'])->name('category.show.home.screen');

        Route::resource('subcategory', SubcategoryController::class);
        Route::get('/fetch/trashed/subcategory', [SubcategoryController::class, 'fetchTrashedSubcategory'])->name('fetch.trashed.subcategory');
        Route::get('/subcategory/restore/{id}', [SubcategoryController::class, 'subcategoryRestore'])->name('subcategory.restore');
        Route::get('/subcategory/forcedelete/{id}', [SubcategoryController::class, 'subcategoryForceDelete'])->name('subcategory.forcedelete');
        Route::get('/subcategory/status/{id}', [SubcategoryController::class, 'subcategoryStatus'])->name('subcategory.status');

        Route::resource('childcategory', ChildcategoryController::class);
        Route::get('/fetch/trashed/childcategory', [ChildcategoryController::class, 'fetchTrashedChildcategory'])->name('fetch.trashed.childcategory');
        Route::get('/childcategory/restore/{id}', [ChildcategoryController::class, 'childcategoryRestore'])->name('childcategory.restore');
        Route::get('/childcategory/forcedelete/{id}', [ChildcategoryController::class, 'childcategoryForceDelete'])->name('childcategory.forcedelete');
        Route::get('/childcategory/status/{id}', [ChildcategoryController::class, 'childcategoryStatus'])->name('childcategory.status');

        Route::resource('brand', BrandController::class);
        Route::get('/fetch/trashed/brand', [BrandController::class, 'fetchTrashedBrand'])->name('fetch.trashed.brand');
        Route::get('/brand/restore/{id}', [BrandController::class, 'brandRestore'])->name('brand.restore');
        Route::get('/brand/forcedelete/{id}', [BrandController::class, 'brandForceDelete'])->name('brand.forcedelete');
        Route::get('/brand/status/{id}', [BrandController::class, 'brandStatus'])->name('brand.status');

        Route::resource('product', ProductController::class);
        Route::post('/product/store/ajax', [ProductController::class, 'productStoreAjax'])->name('product.store.ajax');
        Route::get('/fetch/trashed/product', [ProductController::class, 'fetchTrashedProduct'])->name('fetch.trashed.product');
        Route::post('/get/subcategories', [ProductController::class, 'getSubcategories'])->name('get.subcategories');
        Route::post('/get/childcategories', [ProductController::class, 'getChildcategories'])->name('get.childcategories');
        Route::get('/product/restore/{id}', [ProductController::class, 'productRestore'])->name('product.restore');
        Route::get('/product/forcedelete/{id}', [ProductController::class, 'productForceDelete'])->name('product.forcedelete');
        Route::get('/product/status/{id}', [ProductController::class, 'productStatus'])->name('product.status');
        Route::get('/product/today/deal/status/{id}', [ProductController::class, 'productTodayDealStatus'])->name('product.today.deal.status');

        Route::get('/product/featured/photo/form/{id}', [ProductController::class, 'productFeaturedPhotoForm'])->name('product.featured.photo.form');
        Route::post('/product/featured/photo/store/{id}', [ProductController::class, 'productFeaturedPhotoStore'])->name('product.featured.photo.store');
        Route::get('/product/featured/photo/forcedelete/{id}', [ProductController::class, 'productFeaturedPhotoForceDelete'])->name('product.featured.photo.forcedelete');
        Route::get('/product/inventory/forcedelete/{id}', [ProductController::class, 'productInventoryForceDelete'])->name('product.inventory.forcedelete');

        Route::get('/product/inventory/form/{id}', [ProductController::class, 'productInventoryForm'])->name('product.inventory.form');
        Route::post('/product/inventory/store/{id}', [ProductController::class, 'productInventoryStore'])->name('product.inventory.store');

        Route::get('/product/flashsale/status/form/{id}', [ProductController::class, 'productFlashsaleStatusForm'])->name('product.flashsale.status.form');
        Route::post('/product/flashsale/status/update/{id}', [ProductController::class, 'productFlashsaleStatusUpdate'])->name('product.flashsale.status.update');

        Route::resource('size', SizeController::class);
        Route::get('/fetch/trashed/size', [SizeController::class, 'fetchTrashedSize'])->name('fetch.trashed.size');
        Route::get('/size/restore/{id}', [SizeController::class, 'sizeRestore'])->name('size.restore');
        Route::get('/size/forcedelete/{id}', [SizeController::class, 'sizeForceDelete'])->name('size.forcedelete');
        Route::get('/size/status/{id}', [SizeController::class, 'sizeStatus'])->name('size.status');

        Route::resource('color', ColorController::class);
        Route::get('/fetch/trashed/color', [ColorController::class, 'fetchTrashedColor'])->name('fetch.trashed.color');
        Route::get('/color/restore/{id}', [ColorController::class, 'colorRestore'])->name('color.restore');
        Route::get('/color/forcedelete/{id}', [ColorController::class, 'colorForceDelete'])->name('color.forcedelete');
        Route::get('/color/status/{id}', [ColorController::class, 'colorStatus'])->name('color.status');

        Route::resource('coupon', CouponController::class);
        Route::get('/fetch/trashed/coupon', [CouponController::class, 'fetchTrashedCoupon'])->name('fetch.trashed.coupon');
        Route::get('/coupon/restore/{id}', [CouponController::class, 'couponRestore'])->name('coupon.restore');
        Route::get('/coupon/forcedelete/{id}', [CouponController::class, 'couponForceDelete'])->name('coupon.forcedelete');
        Route::get('/coupon/status/{id}', [CouponController::class, 'couponStatus'])->name('coupon.status');

        Route::resource('flashsale', FlashsaleController::class);
        Route::get('/fetch/trashed/flashsale', [FlashsaleController::class, 'fetchTrashedFlashsale'])->name('fetch.trashed.flashsale');
        Route::get('/flashsale/restore/{id}', [FlashsaleController::class, 'flashsaleRestore'])->name('flashsale.restore');
        Route::get('/flashsale/forcedelete/{id}', [FlashsaleController::class, 'flashsaleForceDelete'])->name('flashsale.forcedelete');
        Route::get('/flashsale/status/{id}', [FlashsaleController::class, 'flashsaleStatus'])->name('flashsale.status');
        Route::get('/flashsale/product/added/{id}', [FlashsaleController::class, 'flashsaleProductAdded'])->name('flashsale.product.added');
        Route::get('/flashsale/product/list', [FlashsaleController::class, 'flashsaleProductList'])->name('flashsale.product.list');
        Route::post('/flashsale/product/update/{id}', [FlashsaleController::class, 'flashsaleProductUpdate'])->name('flashsale.product.update');

        Route::resource('shipping', ShippingController::class);
        Route::get('/fetch/trashed/shipping', [ShippingController::class, 'fetchTrashedShipping'])->name('fetch.trashed.shipping');
        Route::get('/shipping/restore/{id}', [ShippingController::class, 'shippingRestore'])->name('shipping.restore');
        Route::get('/shipping/forcedelete/{id}', [ShippingController::class, 'shippingForceDelete'])->name('shipping.forcedelete');
        Route::get('/shipping/status/{id}', [ShippingController::class, 'shippingStatus'])->name('shipping.status');

        // Blog Resource
        Route::resource('blog_category', Blog_categoryController::class);
        Route::get('/fetch/trashed/blog/category', [Blog_categoryController::class, 'fetchTrashedBlogCategory'])->name('fetch.trashed.blog.category');
        Route::get('/blog/category/restore/{id}', [Blog_categoryController::class, 'blogCategoryRestore'])->name('blog.category.restore');
        Route::get('/blog/category/forcedelete/{id}', [Blog_categoryController::class, 'blogCategoryForceDelete'])->name('blog.category.forcedelete');
        Route::get('/blog/category/status/{id}', [Blog_categoryController::class, 'blogCategoryStatus'])->name('blog.category.status');

        Route::resource('blog', BlogController::class);
        Route::get('/fetch/trashed/blog', [BlogController::class, 'fetchTrashedBlog'])->name('fetch.trashed.blog');
        Route::get('/blog/restore/{id}', [BlogController::class, 'blogRestore'])->name('blog.restore');
        Route::get('/blog/forcedelete/{id}', [BlogController::class, 'blogForceDelete'])->name('blog.forcedelete');
        Route::get('/blog/status/{id}', [BlogController::class, 'blogStatus'])->name('blog.status');

        // Others Page
        Route::resource('slider', SliderController::class);
        Route::get('/fetch/trashed/slider', [SliderController::class, 'fetchTrashedSlider'])->name('fetch.trashed.slider');
        Route::get('/slider/restore/{id}', [SliderController::class, 'sliderRestore'])->name('slider.restore');
        Route::get('/slider/forcedelete/{id}', [SliderController::class, 'sliderForceDelete'])->name('slider.forcedelete');
        Route::get('/slider/status/{id}', [SliderController::class, 'sliderStatus'])->name('slider.status');

        Route::resource('banner', BannerController::class);
        Route::get('/fetch/trashed/banner', [BannerController::class, 'fetchTrashedBanner'])->name('fetch.trashed.banner');
        Route::get('/banner/restore/{id}', [BannerController::class, 'bannerRestore'])->name('banner.restore');
        Route::get('/banner/forcedelete/{id}', [BannerController::class, 'bannerForceDelete'])->name('banner.forcedelete');
        Route::get('/banner/status/{id}', [BannerController::class, 'bannerStatus'])->name('banner.status');

        Route::resource('feature', FeatureController::class);
        Route::get('/fetch/trashed/feature', [FeatureController::class, 'fetchTrashedFeature'])->name('fetch.trashed.feature');
        Route::get('/feature/restore/{id}', [FeatureController::class, 'featureRestore'])->name('feature.restore');
        Route::get('/feature/forcedelete/{id}', [FeatureController::class, 'featureForceDelete'])->name('feature.forcedelete');
        Route::get('/feature/status/{id}', [FeatureController::class, 'featureStatus'])->name('feature.status');

        Route::resource('faq', FaqController::class);
        Route::get('/fetch/trashed/faq', [FaqController::class, 'fetchTrashedFaq'])->name('fetch.trashed.faq');
        Route::get('/faq/restore/{id}', [FaqController::class, 'faqRestore'])->name('faq.restore');
        Route::get('/faq/forcedelete/{id}', [FaqController::class, 'faqForceDelete'])->name('faq.forcedelete');
        Route::get('/faq/status/{id}', [FaqController::class, 'faqStatus'])->name('faq.status');

        Route::resource('team', TeamController::class);
        Route::get('/fetch/trashed/team', [TeamController::class, 'fetchTrashedTeam'])->name('fetch.trashed.team');
        Route::get('/team/restore/{id}', [TeamController::class, 'teamRestore'])->name('team.restore');
        Route::get('/team/forcedelete/{id}', [TeamController::class, 'teamForceDelete'])->name('team.forcedelete');
        Route::get('/team/status/{id}', [TeamController::class, 'teamStatus'])->name('team.status');

        Route::resource('warehouse', WarehouseController::class);
        Route::get('/fetch/trashed/warehouse', [WarehouseController::class, 'fetchTrashedWarehouse'])->name('fetch.trashed.warehouse');
        Route::get('/warehouse/restore/{id}', [WarehouseController::class, 'warehouseRestore'])->name('warehouse.restore');
        Route::get('/warehouse/forcedelete/{id}', [WarehouseController::class, 'warehouseForceDelete'])->name('warehouse.forcedelete');
        Route::get('/warehouse/status/{id}', [WarehouseController::class, 'warehouseStatus'])->name('warehouse.status');

        Route::get('return-orders', [Order_Controller::class, 'returnOrders'])->name('return.orders');
        Route::get('return-order-details/{id}', [Order_Controller::class, 'returnOrderDetails'])->name('return.order.details');
        Route::get('return/order/status/edit/{id}', [Order_Controller::class, 'returnOrderStatusEdit'])->name('return.order.status.edit');
        Route::post('return/order/status/update/{id}', [Order_Controller::class, 'returnOrderStatusUpdate'])->name('return.order.status.update');
    });

    Route::middleware(['warehouse'])->group(function () {
        // All Order
        Route::get('processing-orders', [Order_Controller::class, 'processingOrders'])->name('processing.orders');
        Route::get('delivered-orders', [Order_Controller::class, 'deliveredOrders'])->name('delivered.orders');
        Route::get('cancel-orders', [Order_Controller::class, 'cancelOrders'])->name('cancel.orders');
        Route::get('order-invoice-download/{id}', [Order_Controller::class, 'orderInvoiceDownload'])->name('order.invoice.download');
        Route::get('order-details/{id}', [Order_Controller::class, 'orderDetails'])->name('order.details');
        Route::get('order/status/edit/{id}', [Order_Controller::class, 'orderStatusEdit'])->name('order.status.edit');
        Route::post('order/status/update/{id}', [Order_Controller::class, 'orderStatusUpdate'])->name('order.status.update');
    });
});
