<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutocompleteController;
use App\Http\Controllers\BindeController;
use App\Http\Controllers\BinderController;
use App\Http\Controllers\BinderListController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PressListController;
use App\Http\Controllers\PrintingPressController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WriterController;
use App\Http\Middleware\SuperAdmin;
use App\Models\Book;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;


// Route::get('/dashboard', function () {
//     return view('backend.dashboard.super_admin');
// });

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

// Authentication
Route::get('/create', [AuthController::class, 'index'])->name('registration');
Route::post('/register', [AuthController::class, 'registration'])->name('register');
Route::get('/', [AuthController::class, 'create'])->name('login');
Route::post('/login/store', [AuthController::class, 'login'])->name('login.store');
Route::get('/forget', [AuthController::class, 'forgot'])->name('forgot');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::group(['middleware' => 'super-admin'], function(){

// });

// Route::middleware([SuperAdmin::class])->group(function () {
//     // Define your routes that should be accessible only by super admin here
//     Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');
// });


// Writer
Route::get('/lekhok', [WriterController::class, 'index'])->name('lekhok.index');
Route::get('/lekhok/create', [WriterController::class, 'create'])->name('lekhok.create');
Route::post('/lekhok/store', [WriterController::class, 'store'])->name('lekhok.store');
Route::get('/lekhok/edit/{id}', [WriterController::class, 'edit'])->name('lekhok.edit');
Route::post('/lekhok/update/{id}', [WriterController::class, 'update'])->name('lekhok.update');
Route::get('/lekhok/delete/{id}', [WriterController::class, 'destroy'])->name('lekhok.delete');

// supplier
Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
Route::get('/supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::post('/supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
Route::get('/supplier/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.delete');

// Printing Press list
Route::get('/press_list', [PressListController::class, 'index'])->name('press_list.index');
Route::get('/press_list/create', [PressListController::class, 'create'])->name('press_list.create');
Route::post('/press_list/store', [PressListController::class, 'store'])->name('press_list.store');
Route::get('/press_list/edit/{id}', [PressListController::class, 'edit'])->name('press_list.edit');
Route::post('/press_list/update/{id}', [PressListController::class, 'update'])->name('press_list.update');
Route::get('/press_list/delete/{id}', [PressListController::class, 'destroy'])->name('press_list.delete');

// Printing Press
Route::get('/press', [PrintingPressController::class, 'index'])->name('press.index');
Route::get('/press/create', [PrintingPressController::class, 'create'])->name('press.create');
Route::post('/press/store', [PrintingPressController::class, 'store'])->name('press.store');
Route::get('/press/edit/{id}', [PrintingPressController::class, 'edit'])->name('press.edit');
Route::post('/press/update/{id}', [PrintingPressController::class, 'update'])->name('press.update');
Route::get('/press/delete/{id}', [PrintingPressController::class, 'destroy'])->name('press.delete');

// Binder_list
Route::get('/binder_list', [BinderListController::class, 'index'])->name('binder_list.index');
Route::get('/binder_list/create', [BinderListController::class, 'create'])->name('binder_list.create');
Route::post('/binder_list/store', [BinderListController::class, 'store'])->name('binder_list.store');
Route::get('/binder_list/edit/{id}', [BinderListController::class, 'edit'])->name('binder_list.edit');
Route::post('/binder_list/update/{id}', [BinderListController::class, 'update'])->name('binder_list.update');
Route::get('/binder_list/delete/{id}', [BinderListController::class, 'destroy'])->name('binder_list.delete');

// Binder
Route::get('/binders', [BinderController::class, 'index'])->name('binder.index');
Route::get('/total/binder', [BindeController::class, 'binder'])->name('total.binder');
Route::get('/binder/create', [BinderController::class, 'create'])->name('binder.create');
Route::post('/binder/store', [BinderController::class, 'store'])->name('binder.store');
Route::get('/binder/edit/{id}', [BinderController::class, 'edit'])->name('binder.edit');
Route::post('/binder/update/{id}', [BinderController::class, 'update'])->name('binder.update');
Route::get('/binder/delete/{id}', [BinderController::class, 'destroy'])->name('binder.delete');

// category
Route::get('/category', [CategoryController::class, 'index'])->name('categories');
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::get('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');

// book
Route::get('/boi', [BookController::class, 'index'])->name('boi');
Route::get('/boi/create', [BookController::class, 'create'])->name('boi.create');
Route::post('/boi/store', [BookController::class, 'store'])->name('boi.store');
Route::get('/boi/edit/{id}', [BookController::class, 'edit'])->name('boi.edit');
Route::post('/boi/update/{id}', [BookController::class, 'update'])->name('boi.update');
Route::get('/boi/delete/{id}', [BookController::class, 'destroy'])->name('boi.delete');

// Stock
Route::get('/store', [StockController::class, 'index'])->name('stocks');
Route::get('/store/create', [StockController::class, 'create'])->name('store.create');
Route::post('/stock/store', [StockController::class, 'restock'])->name('store.restock');
Route::get('/stock_detail', [StockController::class, 'in_stock'])->name('stockDetails');
Route::get('/stock/edit/{id}', [StockController::class, 'edit'])->name('stock.edit');
Route::post('/stock/update/{id}', [StockController::class, 'update'])->name('stock.update');
Route::get('/stock/delete/{id}', [StockController::class, 'destroy'])->name('stock.delete');

Route::get('/nonbinder/create', [StockController::class, 'nonbinder'])->name('nonbinder.create');
Route::post('/stock/nonbinder', [StockController::class, 'stockNonbinder'])->name('stock.nonbinder');

// customer
Route::get('/Customer', [CustomerController::class, 'index'])->name('customers');
Route::get('/Customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::post('/Customer/store', [CustomerController::class, 'store'])->name('customer.store');
Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
Route::post('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::get('/customer/delete/{id}', [CustomerController::class, 'destroy'])->name('customer.delete');

// Transaction or Sales
Route::get('/transaction', [TransactionController::class, 'index'])->name('transactions.index');

Route::get('/today/transaction', [TransactionController::class, 'todayTransaction'])->name('transactions.today');

Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');

Route::get('/books/search', [TransactionController::class, 'searchBooks'])->name('books.search');

Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');

Route::get('/transactions/edit/{id}', [TransactionController::class, 'edit'])->name('transactions.edit');

Route::post('/transactions/update/{id}', [TransactionController::class, 'update'])->name('transactions.update');

// Invoice Generate
Route::get('/transactions/print', [TransactionController::class, 'print_show'])->name('transactions.print_show');

Route::get('/transactions/invo/{id}', [TransactionController::class, 'invoice'])->name('transactions.invoice');


Route::get('extra/report/pdf', [TransactionController::class, 'reportPDF'])
->name('report.pdf');


Route::get('invoice/print', [TransactionController::class, 'print'])
->name('invoice.print');

// report Generate
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::post('/reports/result', [ReportController::class, 'generate'])->name('reports.generate');


//Autocomplete

Route::get('/customer/list', [AutocompleteController::class,'customer'])->name('customer.list');
Route::get('books', [AutocompleteController::class,'book'])->name('book.list');


// Pos Interface
Route::get('/pos', function () {
    $customers = Customer::all();
    $books = Book::all();
    return view('backend.sale.search_dropdwon',compact('customers','books'));
});
// Route::get('/invo', function () {
//     return view('backend.invoice.invo');
// });

Route::get('/report', function () {
    return view('backend.report.salesreport');
});
