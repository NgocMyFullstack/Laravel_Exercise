<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', 'App\Http\Controllers\FrontendController@home')->name('home');

route::get('/product-detail/{slug}','App\Http\Controllers\FrontendController@productDetail')->name('product-detail');
// Route::get('/', function () {
//     return view('welcome');
//     Auth::routes(['register' => false]);

//     Route::get('user/login', 'FrontendController@login')->name('login.form');
//     Route::post('user/login', 'FrontendController@loginSubmit')->name('login.submit');
//     Route::get('user/logout', 'FrontendController@logout')->name('user.logout');
//     Route::get('user/register', 'FrontendController@register')->name('register.form');
//     Route::post('user/register', 'FrontendController@registerSubmit')->name('register.submit');

//     // Reset password
//     Route::post('password-reset', 'FrontendController@showResetForm')->name('password.reset');

//     // Socialite
//     Route::get('login/{provider}/', 'Auth\LoginController@redirect')->name('login.redirect');
//     Route::get('login/{provider}/callback/', 'Auth\LoginController@Callback')->name('login.callback');
//     Route::get('/', 'FrontendController@home')->name('home');

//     // Frontend Routes
//     Route::get('/home', 'FrontendController@home');
//     Route::get('/about-us', 'FrontendController@aboutUs')->name('about-us');
//     Route::get('/contact', 'FrontendController@contact')->name('contact');
//     Route::post('/contact/message', 'MessageController@store')->name('contact.store');
//     Route::get('product-detail/{slug}', 'FrontendController@productDetail')->name('product-detail');
//     Route::post('/product/search', 'FrontendController@productSearch')->name('product.search');
//     Route::get('/product-cat/{slug}', 'FrontendController@productCat')->name('product-cat');
//     Route::get('/product-sub-cat/{slug}/{sub_slug}', 'FrontendController@productSubCat')->name('product-
// sub-cat');
//     Route::get('/product-brand/{slug}', 'FrontendController@productBrand')->name('product-brand');

//     // Cart section
//     Route::get('/add-to-cart/{slug}', 'CartController@addToCart')->name('add-to- cart')->middleware('user');
//     Route::post('/add-to-cart', 'CartController@singleAddToCart')->name('single- add-to-cart')->middleware('user');
//     Route::get('cart-delete/{id}', 'CartController@cartDelete')->name('cart-
// delete');
//     Route::post('cart-update', 'CartController@cartUpdate')->name('cart.update');
//     Route::get('/cart', function () {
//         return view('frontend.pages.cart');
//     })->name('cart');
//     Route::get('/checkout', 'CartController@checkout')->name('checkout')->middleware('user');

//     // Wishlist
//     Route::get('/wishlist', function () {
//         return view('frontend.pages. wishlist');
//     })->name('wishlist');
//     Route::get('/wishlist/{slug}', 'WishlistController@wishlist')->name('add-to- wishlist')->middleware('user');
//     Route::get('wishlist-delete/{id}', 'WishlistController@wishlistDelete')->name('wishlist-delete');
//     Route::post('cart/order', 'OrderController@store')->name('cart.order');
//     Route::get('order/pdf/{id}', 'OrderController@pdf')->name('order.pdf');
//     Route::get('/income', 'OrderController@incomeChart')->name('product.order.income');

//     // Route::get('/user/chart', 'AdminController@userPieChart')- >name('user.piechart');
//     Route::get('/product-grids', 'FrontendController@productGrids')->name('product-grids');
//     Route::get('/product-lists', 'FrontendController@productLists')->name('product-lists');
//     Route::match(['get', 'post'], '/filter', 'FrontendController@productFilter')->name('shop.filter');

//     // Order Track
//     Route::get('/product/track', 'OrderController@orderTrack')->name('order.track');
//     Route::post('product/track/order', 'OrderController@productTrackOrder')->name('product.track.order');

//     // Blog
//     Route::get('/blog', 'FrontendController@blog')->name('blog');
//     Route::get('/blog-detail/{slug}', 'FrontendController@blogDetail')->name('blog.detail');
//     Route::get('/blog/search', 'FrontendController@blogSearch')->name('blog.search');
//     Route::post('/blog/filter', 'FrontendController@blogFilter')->name('blog.filter');
//     Route::get('blog-cat/{slug}', 'FrontendController@blogByCategory')->name('blog.category');
//     Route::get('blog-tag/{slug}', 'FrontendController@blogByTag')->name('blog.tag');

//     // NewsLetter
//     Route::post('/subscribe', 'FrontendController@subscribe')->name('subscribe');

//     // Product Review
//     Route::resource('/review', 'ProductReviewController');
//     Route::post('product/{slug}/review', 'ProductReviewController@store')->name('review.store');

//     // Post Comment
//     Route::post('post/{slug}/comment', 'PostCommentController@store')->name('post-comment.store');
//     Route::resource('/comment', 'PostCommentController');

//     // Coupon
//     Route::post('/coupon-store', 'CouponController@couponStore')->name('coupon-store');

//     // Payment
//     Route::get('payment', 'PayPalController@payment')->name('payment');
//     Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
//     Route::get('payment/success', 'PayPalController@success')->name('payment.success');
// });
