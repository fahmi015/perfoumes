<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\{
    adminController,
    BrandController,
    UplodeFileController,
    ProductController,
    CategoryController,
    PackController,
    PackProductController
};
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [adminController::class, 'index'])->name('dashboard');

    Route::resource('brands', BrandController::class);
    
    Route::post('/categories/save',[CategoryController::class,'save'])->name('categories.save');

    Route::resource('categories', CategoryController::class)->except(['edit','create','show']);
    Route::resource('products', ProductController::class);
    Route::resource('packs', PackController::class);
    Route::resource('packProducts',PackProductController::class);
    
    
    Route::post('/file/uplode/filePond',[UplodeFileController::class,'FilePond'])->name('uplode.by.FilePond');
    Route::post('/file/uplode/ckeditor',[UplodeFileController::class,'Ckeditor'])->name('uplode.by.ckeditor');

});


