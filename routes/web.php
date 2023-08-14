<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SupplierController;

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

Route::get('/', [HomeController::class, 'index'])->name('home-page');

# Language management
Route::get('lang/home', [LangController::class, 'index']);
Route::get('lang/change', [LangController::class, 'change'])->name('change-lang');

#region captcha
Route::get('my-captcha', [HomeController::class, 'myCaptcha'])->name('myCaptcha');
Route::post('my-captcha', [HomeController::class, 'myCaptchaPost'])->name('myCaptcha.post');
Route::get('refresh_captcha', [HomeController::class, 'refreshCaptcha'])->name('refresh_captcha');
#endregion captcha

#endregion contact
Route::post('contact-us', [ContactController::class, 'store'])->name('contact.us.message');
#region contact


# Dashboard management
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('product', ProductController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/setting', SettingController::class);
    Route::resource('/supplier', SupplierController::class);

    Route::resource('/achat', ProductSupplierController::class);
    Route::resource('/customer', CustomerController::class);

    ## print to pdf
    Route::get('/pdf-barcode', [ProductController::class, 'BarcodeToPDF'])->name('barcode.to.pdf');
});

require __DIR__.'/auth.php';
