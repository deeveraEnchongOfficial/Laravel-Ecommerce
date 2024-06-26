<?php

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

Auth::routes(['register'=>false]);

Route::get('user/login','FrontendController@login')->name('login.form');
Route::post('user/login','FrontendController@loginSubmit')->name('login.submit');
Route::get('user/logout','FrontendController@logout')->name('user.logout');

Route::get('user/register','FrontendController@register')->name('register.form');
Route::post('user/register','FrontendController@registerSubmit')->name('register.submit');
// Reset password
Route::post('password-reset', 'FrontendController@showResetForm')->name('password.reset');
// Socialite
Route::get('login/{provider}/', 'Auth\LoginController@redirect')->name('login.redirect');
Route::get('login/{provider}/callback/', 'Auth\LoginController@Callback')->name('login.callback');
Route::post('pass-reset', 'FrontendController@reset')->name('pass.reset');
Route::get('reset-verify', 'FrontendController@verify')->name('reset-verify');
Route::post('pass-change', 'FrontendController@passChange')->name('pass.change');

Route::get('/','FrontendController@home')->name('home');

// Frontend Routes
Route::get('/home', 'FrontendController@index');
Route::get('/about-us','FrontendController@aboutUs')->name('about-us');
Route::get('/contact','FrontendController@contact')->name('contact');
Route::post('/contact/message','MessageController@store')->name('contact.store');
Route::get('product-detail/{slug}','FrontendController@productDetail')->name('product-detail');
Route::post('/product/search','FrontendController@productSearch')->name('product.search');
Route::get('/product-cat/{slug}','FrontendController@productCat')->name('product-cat');
Route::get('/product-sub-cat/{slug}/{sub_slug}','FrontendController@productSubCat')->name('product-sub-cat');
Route::get('/product-brand/{slug}','FrontendController@productBrand')->name('product-brand');
// Cart section
Route::get('/add-to-cart/{slug}','CartController@addToCart')->name('add-to-cart')->middleware('user');
Route::post('/add-to-cart','CartController@singleAddToCart')->name('single-add-to-cart')->middleware('user');
Route::get('cart-delete/{id}','CartController@cartDelete')->name('cart-delete');
Route::post('cart-update','CartController@cartUpdate')->name('cart.update');

Route::get('/fetch-distance-matrix', 'DistanceMatrixController@fetchDistanceMatrix')->name('distance-metric');

Route::get('/cart',function(){
    return view('frontend.pages.cart');
})->name('cart');
Route::get('/checkout','CartController@checkout')->name('checkout')->middleware('user');
// Wishlist
Route::get('/wishlist',function(){
    return view('frontend.pages.wishlist');
})->name('wishlist');
Route::get('/wishlist/{slug}','WishlistController@wishlist')->name('add-to-wishlist')->middleware('user');
Route::get('wishlist-delete/{id}','WishlistController@wishlistDelete')->name('wishlist-delete');

// Like
Route::get('/like',function(){
    return view('frontend.pages.like');
})->name('like');
Route::get('/like/{slug}','LikeController@like')->name('add-to-like')->middleware('user');
Route::get('like-delete/{id}','LikeController@likeDelete')->name('like-delete');

Route::get('/product-sales-chart', 'ProductController@productSalesChart')->name('product-sales-chart');
Route::post('cart/order','OrderController@store')->name('cart.order');
Route::get('order/pdf/{id}','OrderController@pdf')->name('order.pdf');
Route::get('/income','OrderController@incomeChart')->name('product.order.income');
Route::get('/yearly-earnings', 'OrderController@yearlyEarningsChart')->name('yearly.earnings');
Route::get('/weekly-income', 'OrderController@weeklyIncomeChart')->name('weekly.income');
Route::get('/yearly-earnings', 'OrderController@yearlyEarningsChart')->name('yearly.earnings');
Route::get('/daily-earnings', 'OrderController@dailyEarningsChart')->name('daily.earnings');
Route::get('/user/chart','AdminController@userPieChart')->name('user.piechart');
Route::get('/product-grids','FrontendController@productGrids')->name('product-grids');
Route::get('/product-lists','FrontendController@productLists')->name('product-lists');
Route::get('/product-high-reviews','FrontendController@productHighReviews')->name('product-high-reviews');
Route::match(['get','post'],'/product-reviews-filter','FrontendController@productReviewFilter')->name('shop-review.filter');
Route::match(['get','post'],'/filter','FrontendController@productFilter')->name('shop.filter');
// Order Track
Route::get('/product/track','OrderController@orderTrack')->name('order.track');
Route::post('product/track/order','OrderController@productTrackOrder')->name('product.track.order');
// Blog
Route::get('/blog','FrontendController@blog')->name('blog');
Route::get('/blog-detail/{slug}','FrontendController@blogDetail')->name('blog.detail');
Route::get('/blog/search','FrontendController@blogSearch')->name('blog.search');
Route::post('/blog/filter','FrontendController@blogFilter')->name('blog.filter');
Route::get('blog-cat/{slug}','FrontendController@blogByCategory')->name('blog.category');
Route::get('blog-tag/{slug}','FrontendController@blogByTag')->name('blog.tag');

// NewsLetter
Route::post('/subscribe','FrontendController@subscribe')->name('subscribe');

// Product Review
Route::resource('/review','ProductReviewController');
Route::post('product/{slug}/review','ProductReviewController@store')->name('review.store');

// Post Comment
Route::post('post/{slug}/comment','PostCommentController@store')->name('post-comment.store');
Route::resource('/comment','PostCommentController');
// Coupon
Route::post('/coupon-store','CouponController@couponStore')->name('coupon-store');
// Payment
Route::get('payment', 'PayPalController@payment')->name('payment');
Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
Route::get('payment/success', 'PayPalController@success')->name('payment.success');


// Backend section start

Route::group(['prefix'=>'/admin','middleware'=>['auth','admin']],function(){
    Route::get('/','AdminController@index')->name('admin');
    Route::get('/file-manager',function(){
        return view('backend.layouts.file-manager');
    })->name('file-manager');
    // user route
    Route::resource('users','UsersController');
    // Banner
    Route::resource('banner','BannerController');
    // Brand
    Route::resource('brand','BrandController');
    // Profile
    Route::get('/profile','AdminController@profile')->name('admin-profile');
    Route::post('/profile/{id}','AdminController@profileUpdate')->name('profile-update');
    // Category
    Route::resource('/category','CategoryController');
    // Product
    Route::resource('/product','ProductController');
    // Ajax for sub category
    Route::post('/category/{id}/child','CategoryController@getChildByParent');
    // POST category
    Route::resource('/post-category','PostCategoryController');
    // Post tag
    Route::resource('/post-tag','PostTagController');
    // Post
    Route::resource('/post','PostController');
    // Message
    Route::resource('/message','MessageController');
    Route::get('/message/five','MessageController@messageFive')->name('messages.five');

    // Order
    Route::resource('/order','OrderController');
    // Shipping
    Route::resource('/shipping','ShippingController');
    // Coupon
    Route::resource('/coupon','CouponController');
    // Settings
    Route::get('settings','AdminController@settings')->name('settings');
    Route::post('setting/update','AdminController@settingsUpdate')->name('settings.update');

    // Notification
    Route::get('/notification/{id}','NotificationController@show')->name('admin.notification');
    Route::get('/notifications','NotificationController@index')->name('all.notification');
    Route::delete('/notification/{id}','NotificationController@delete')->name('notification.delete');
    // Password Change
    Route::get('change-password', 'AdminController@changePassword')->name('change.password.form');
    Route::post('change-password', 'AdminController@changPasswordStore')->name('change.password');

    Route::patch('/refund/status/udpate/{id}','RefundController@refundStatusUpdate')->name('refund.status.update');
    Route::resource('/refund','RefundController');
    // update_refund_status
});

// User section start
Route::group(['prefix'=>'/user','middleware'=>['user']],function(){
    Route::get('/','HomeController@index')->name('user');
     // Profile
     Route::get('/profile','HomeController@profile')->name('user-profile');
     Route::post('/profile/{id}','HomeController@profileUpdate')->name('user-profile-update');
    //  Order
    Route::get('/order',"HomeController@orderIndex")->name('user.order.index');
    Route::get('/order/show/{id}',"HomeController@orderShow")->name('user.order.show');
    Route::delete('/order/delete/{id}','HomeController@userOrderDelete')->name('user.order.delete');
    // Product Review
    Route::get('/user-review','HomeController@productReviewIndex')->name('user.productreview.index');
    Route::delete('/user-review/delete/{id}','HomeController@productReviewDelete')->name('user.productreview.delete');
    Route::get('/user-review/edit/{id}','HomeController@productReviewEdit')->name('user.productreview.edit');
    Route::patch('/user-review/update/{id}','HomeController@productReviewUpdate')->name('user.productreview.update');

    // Post comment
    Route::get('user-post/comment','HomeController@userComment')->name('user.post-comment.index');
    Route::delete('user-post/comment/delete/{id}','HomeController@userCommentDelete')->name('user.post-comment.delete');
    Route::get('user-post/comment/edit/{id}','HomeController@userCommentEdit')->name('user.post-comment.edit');
    Route::patch('user-post/comment/udpate/{id}','HomeController@userCommentUpdate')->name('user.post-comment.update');

    // Password Change
    Route::get('change-password', 'HomeController@changePassword')->name('user.change.password.form');
    Route::post('change-password', 'HomeController@changPasswordStore')->name('change.password');

    // Notification
    Route::get('/notification/{id}','HomeController@notificationShow')->name('user.notification');
    Route::get('/notifications','HomeController@notificationIndex')->name('user.all.notification');
    Route::delete('/notification/{id}','@notificationDelete')->name('user.notification.delete');

    // Route::resource('/refund','RefundController');
    Route::get('/refund/create/{id}','HomeController@refundCreate')->name('order.refund.create');
    Route::post('/refund/store','HomeController@refundStore')->name('order.refund.store');
    Route::get('/refund/list','HomeController@refundIndex')->name('order.refund.index');
    Route::get('/refund/show/{id}','HomeController@refundshow')->name('order.refund.show');
    Route::delete('/refund/show/{id}','HomeController@refundDelete')->name('order.refund.delete');

    Route::get('/location','UserLocationController@index')->name('location.index');
    Route::get('/location/create','UserLocationController@create')->name('location.create');
    Route::get('/location/edit/{id}','UserLocationController@edit')->name('location.edit');
    Route::post('/location/store','UserLocationController@store')->name('location.store');
    Route::patch('/location/update/{id}','UserLocationController@update')->name('location.update');
    Route::delete('/location/delete/{id}','UserLocationController@destroy')->name('location.destroy');
});

Route::group(['prefix'=>'/delivery_user','middleware'=>['delivery_user']],function(){
    Route::get('/','DeliveryHomeController@index')->name('delivery_user');
     // Profile
     Route::get('/profile','DeliveryHomeController@profile')->name('delivery_user-profile');
     Route::post('/profile/{id}','DeliveryHomeController@profileUpdate')->name('delivery_user-profile-update');
    //  Order
    Route::get('/order',"DeliveryHomeController@orderIndex")->name('delivery_user.order.index');
    Route::get('/order/show/{id}',"DeliveryHomeController@orderShow")->name('delivery_user.order.show');
    Route::get('/order/edit/{id}',"DeliveryHomeController@orderEdit")->name('delivery_user.order.edit');
    Route::patch('/order/update/{id}',"DeliveryHomeController@orderUpdate")->name('delivery_user.order.orderUpdate');
    Route::delete('/order/delete/{id}','DeliveryHomeController@userOrderDelete')->name('delivery_user.order.delete');
    // Product Review
    Route::get('/user-review','DeliveryHomeController@productReviewIndex')->name('delivery_user.productreview.index');
    Route::delete('/user-review/delete/{id}','DeliveryHomeController@productReviewDelete')->name('delivery_user.productreview.delete');
    Route::get('/user-review/edit/{id}','DeliveryHomeController@productReviewEdit')->name('delivery_user.productreview.edit');
    Route::patch('/user-review/update/{id}','DeliveryHomeController@productReviewUpdate')->name('delivery_user.productreview.update');

    // Post comment
    Route::get('user-post/comment','DeliveryHomeController@userComment')->name('delivery_user.post-comment.index');
    Route::delete('user-post/comment/delete/{id}','DeliveryHomeController@userCommentDelete')->name('delivery_user.post-comment.delete');
    Route::get('user-post/comment/edit/{id}','DeliveryHomeController@userCommentEdit')->name('delivery_user.post-comment.edit');
    Route::patch('user-post/comment/udpate/{id}','DeliveryHomeController@userCommentUpdate')->name('delivery_user.post-comment.update');

    // Password Change
    Route::get('change-password', 'DeliveryHomeController@changePassword')->name('delivery_user.change.password.form');
    Route::post('change-password', 'DeliveryHomeController@changPasswordStore')->name('change.password');

    // Notification
    // Route::get('/notification/{id}','NotificationController@show')->name('admin.notification');
    // Route::get('/notifications','NotificationController@index')->name('all.notification');
    // Route::delete('/notification/{id}','NotificationController@delete')->name('notification.delete');

});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
