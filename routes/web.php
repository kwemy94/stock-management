<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Sale\SaleController;
use App\Http\Controllers\Sale\SaleInvoiceController;
use App\Http\Controllers\buy\BuyInvoiceController;
use App\Http\Controllers\ProductSupplierController;
use App\Http\Controllers\Treasury\RecipeController;
use App\Http\Controllers\Treasury\AnalyseController;
use App\Http\Controllers\Treasury\ExpenseController;
use App\Http\Controllers\API\EtablissementController;
use App\Http\Controllers\Inventory\InventoryController;

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

Route::view('/order/create/{path?}', 'admin.pos.order.create')
    ->where('path', '.*');

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
Route::get('contactez-nous', [ContactController::class, 'index'])->name('contact.us');
Route::post('contact-us', [ContactController::class, 'store'])->name('contact.us.message');
#region contact


# Dashboard management
// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'dashboardHome'] )->middleware(['auth', 'verified'])->name('dashboard');

Route::Post('/app-sub-script', [EtablissementController::class, 'store'])->name('app.sub.scribt');
Route::get('/app-company', [EtablissementController::class, 'nosCompany'])->name('app.company');
Route::post('/app-activate-company/{id}', [EtablissementController::class, 'activateEts'])->name('app.activate.company');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('product', ProductController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/setting', SettingController::class);
    Route::resource('/supplier', SupplierController::class);

    Route::resource('/achat', ProductSupplierController::class);
    #Inventaire
    Route::get('/syst-inventory', [ProductSupplierController::class, 'inventory'])->name('syst.inventory');
    Route::post('/store-inventory', [ProductSupplierController::class, 'storeInventory'])->name('store.inventory');
    Route::get('/inventaire-histo', [InventoryController::class, 'history'])->name('histo.inventaire');
    Route::get('/invent-histo-print/{date_inv}', [InventoryController::class, 'printInventory'])->name('print.inventaire');

    Route::resource('/customer', CustomerController::class);
    Route::resource('/unite-mesure', UnitController::class);

    Route::resource('/order', OrderController::class);
    Route::get('print-invoice/{id}', [OrderController::class, 'printInvoice'])->name('order.print.invoice');

    ## print to pdf
    Route::get('/pdf-barcode', [ProductController::class, 'BarcodeToPDF'])->name('barcode.to.pdf');

    ## pos
    Route::get('/pos-data-loading', [OrderController::class, 'loadProduct']);

    ## Vente
    Route::resource('sale', SaleController::class);
    Route::get('sale-invoice/{all?}', [SaleInvoiceController::class, 'index'])->name('sale.invoice');
    Route::get('sale-invoice-create/{type}', [SaleInvoiceController::class, 'create'])->name('sale.invoice.create');
    Route::get('sale-invoice-data', [SaleInvoiceController::class, 'dataCreateInvoice'])->name('sale.invoice.data');
    Route::post('sale-invoice-store', [SaleInvoiceController::class, 'store'])->name('sale.invoice.store');
    Route::post('sale-invoice-update/{id}', [SaleInvoiceController::class, 'update'])->name('sale.invoice.update');
    Route::get('sale-invoice-edit/{id}', [SaleInvoiceController::class, 'edit'])->name('sale.invoice.edit');
    Route::get('sale-invoice-details/{id}', [SaleInvoiceController::class, 'show'])->name('sale.invoice.show');
    Route::get('sale-invoice-confirm/{id}', [SaleInvoiceController::class, 'confirmInvoice'])->name('sale.invoice.confirm');
    Route::get('sale-invoice-rapport', [SaleInvoiceController::class, 'rapport'])->name('sale.invoice.rapport');
    Route::post('sale-invoice-payment', [SaleInvoiceController::class, 'payment'])->name('sale.invoice.payment');


    ## Buy
    Route::get('buy-home', [BuyInvoiceController::class, 'index'])->name('buy.home');
    Route::get('buy-invoice-create', [BuyInvoiceController::class, 'create'])->name('buy.invoice.create');

    ## inventory
    Route::resource('/inventory', InventoryController::class);

    Route::group(['prefix'=>'treasury'], function(){
        Route::get('/analyse', [AnalyseController::class, 'index'])->name('analyse.treso');
        Route::resource('/recipe', RecipeController::class);
        Route::resource('/expense', ExpenseController::class);
    });
});

require __DIR__.'/auth.php';
