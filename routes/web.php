<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController as BlogPublicController;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\PageController as PagePublic;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\SitemapController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\CategoryBlogController;
use App\Http\Controllers\Admin\BlogController;

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
Route::get('/', [HomeController::class, 'home'])->name('main.home');
Route::get('/error', [\App\Http\Controllers\ErrorController::class, 'handle'])->name('error.handle');
Route::get('/category', [HomeController::class, 'category'])->name('main.category');
Route::get('/product', [HomeController::class, 'product'])->name('main.product');
/* page */
Route::get('/san-pham-khuyen-mai', [PagePublic::class, 'saleOff'])->name('main.saleOff');
Route::get('/tim-kiem-san-pham', [PagePublic::class, 'searchProduct'])->name('main.searchProduct');
Route::get('/tin-tuc', [BlogPublicController::class, 'index'])->name('main.blog');
/* cart */
Route::get('/gio-hang', [CartController::class, 'index'])->name('main.cart');
Route::get('/addToCart', [CartController::class, 'addToCart'])->name('main.addToCart');
Route::get('/updateCart', [CartController::class, 'updateCart'])->name('main.updateCart');
Route::get('/removeProductCart', [CartController::class, 'removeProductCart'])->name('main.removeProductCart');
Route::get('/viewSortCart', [CartController::class, 'viewSortCart'])->name('main.viewSortCart');
/* check out */
Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('main.checkout');
/* order */
Route::post('/order', [OrderController::class, 'create'])->name('main.order');
Route::get('/viewConfirm', [OrderController::class, 'viewConfirm'])->name('main.viewConfirm');
/* sitemap */
Route::get('sitemap.xml', [SitemapController::class, 'main'])->name('sitemap.main');
Route::get('sitemap/{type}.xml', [SitemapController::class, 'child'])->name('sitemap.child');
/* AJAX */
Route::get('/buildTocContentMain', [HomeController::class, 'buildTocContentMain'])->name('main.buildTocContentMain');
Route::get('/loadLoading', [AjaxController::class, 'loadLoading'])->name('ajax.loadLoading');
Route::get('/loadDistrictByIdProvince', [AjaxController::class, 'loadDistrictByIdProvince'])->name('ajax.loadDistrictByIdProvince');
Route::get('/setOptionProduct', [AjaxController::class, 'setOptionProduct'])->name('ajax.setOptionProduct');
Route::get('/searchProductAjax', [AjaxController::class, 'searchProductAjax'])->name('ajax.searchProductAjax');
Route::get('/registryEmail', [AjaxController::class, 'registryEmail'])->name('ajax.registryEmail');
/* login */
Route::get('/admin', [LoginController::class, 'loginForm'])->name('admin.loginForm');
Route::post('/loginAdmin', [LoginController::class, 'loginAdmin'])->name('admin.loginAdmin');
Route::get('/createUser', [LoginController::class, 'create'])->name('admin.createUser');
Route::middleware(['auth'])->group(function () {
    /* product */
    Route::prefix('product')->group(function(){
        Route::get('/list', [ProductController::class, 'list'])->name('admin.product.list');
        Route::get('/view', [ProductController::class, 'view'])->name('admin.product.view');
        Route::post('/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/update', [ProductController::class, 'update'])->name('admin.product.update');
        Route::post('/uploadImageProductPriceAjax', [ProductController::class, 'uploadImageProductPriceAjax'])->name('admin.product.uploadImageProductPriceAjax');
    });
    /* category */
    Route::prefix('category')->group(function(){
        Route::get('/list', [CategoryController::class, 'list'])->name('admin.category.list');
        Route::get('/view', [CategoryController::class, 'view'])->name('admin.category.view');
        Route::post('/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/update', [CategoryController::class, 'update'])->name('admin.category.update');
    });
    /* brand */
    Route::prefix('brand')->group(function(){
        Route::get('/list', [BrandController::class, 'list'])->name('admin.brand.list');
        Route::get('/view', [BrandController::class, 'view'])->name('admin.brand.view');
        Route::post('/create', [BrandController::class, 'create'])->name('admin.brand.create');
        Route::post('/update', [BrandController::class, 'update'])->name('admin.brand.update');
    });
    /* page */
    Route::prefix('page')->group(function(){
        Route::get('/list', [PageController::class, 'list'])->name('admin.page.list');
        Route::get('/view', [PageController::class, 'view'])->name('admin.page.view');
        Route::post('/create', [PageController::class, 'create'])->name('admin.page.create');
        Route::post('/update', [PageController::class, 'update'])->name('admin.page.update');
    });
    /* ===== Category Blog ===== */
    Route::prefix('categoryBlog')->group(function(){
        Route::get('/', [CategoryBlogController::class, 'list'])->name('admin.categoryBlog.list');
        Route::post('/create', [CategoryBlogController::class, 'create'])->name('admin.categoryBlog.create');
        Route::get('/view', [CategoryBlogController::class, 'view'])->name('admin.categoryBlog.view');
        Route::post('/update', [CategoryBlogController::class, 'update'])->name('admin.categoryBlog.update');
    });
    /* ===== Blog ===== */
    Route::prefix('blog')->group(function(){
        Route::get('/', [BlogController::class, 'list'])->name('admin.blog.list');
        Route::post('/create', [BlogController::class, 'create'])->name('admin.blog.create');
        Route::get('/view', [BlogController::class, 'view'])->name('admin.blog.view');
        Route::post('/update', [BlogController::class, 'update'])->name('admin.blog.update');
        /* Delete AJAX */
        Route::get('/delete', [BlogController::class, 'delete'])->name('admin.blog.delete');
    });
    /* setting */
    Route::prefix('setting')->group(function(){
        Route::get('/view', [SettingController::class, 'view'])->name('admin.setting.view');
    });
    /* slider */
    Route::prefix('slider')->group(function(){
        Route::post('/remove', [SliderController::class, 'remove'])->name('admin.slider.remove');
    });
    /* gallery */
    Route::prefix('gallery')->group(function(){
        Route::post('/remove', [GalleryController::class, 'remove'])->name('admin.gallery.remove');
    });
    /* image */
    Route::prefix('image')->group(function(){
        Route::get('/', [ImageController::class, 'list'])->name('admin.image.list');
        Route::post('/uploadImages', [ImageController::class, 'uploadImages'])->name('admin.image.uploadImages');
        Route::post('/loadImage', [ImageController::class, 'loadImage'])->name('admin.image.loadImage');
        Route::post('/loadModal', [ImageController::class, 'loadModal'])->name('admin.image.loadModal');
        Route::post('/changeName', [ImageController::class, 'changeName'])->name('admin.image.changeName');
        Route::post('/changeImage', [ImageController::class, 'changeImage'])->name('admin.image.changeImage');
        Route::post('/removeImage', [ImageController::class, 'removeImage'])->name('admin.image.removeImage');

        // Route::get('/toolRename', [ImageController::class, 'toolRename'])->name('admin.image.toolRename');
    });
});
/* ROUTING */
Route::get("/{slug}/{slug2?}/{slug3?}/{slug4?}/{slug5?}/{slug6?}/{slug7?}/{slug8?}/{slug9?}/{slug10?}", [RoutingController::class, 'routing'])->name('routing');