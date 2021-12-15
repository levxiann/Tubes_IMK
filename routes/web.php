<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\DiscountController;
use App\Models\Stock;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [HomeController::class, 'index']);

Route::get('/order', [ReceiptController::class, 'index']);

Route::get('/order/search', [ReceiptController::class, 'search']);

Route::post('/order/getOrder', [ReceiptController::class, 'getOrder']);

Route::post('/order/store', [ReceiptController::class, 'store']);

Route::get('/receipt', [ReceiptController::class, 'receipt']);

Route::post('/order/getReceiptOrder', [ReceiptController::class, 'getReceiptOrder']);

Route::patch('/order/update', [ReceiptController::class, 'update']);

Route::delete('/order/delete/{id}', [ReceiptController::class, 'destroy']);

Route::delete('/order/cancel/{id}', [ReceiptController::class, 'cancel']);

Route::post('/pay', [ReceiptController::class, 'pay']);

Route::post('/invoice', [ReceiptController::class, 'invoice']);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/discount', [DiscountController::class, 'index'])->name('discount');

Route::get('/discount/search', [DiscountController::class, 'search']);

Route::patch('/discount/update', [DiscountController::class, 'update']);

Route::post('/discount/getDiscountDetail', [DiscountController::class, 'getDetail']);

Route::post('/discount/store', [DiscountController::class, 'store']);

Route::post('/discount/getProductDetail', [DiscountController::class, 'getProductDetail']);

Route::delete('/discount/delete/{id}', [DiscountController::class, 'destroy']);

Route::get('/stock', [StockController::class, 'index']);

Route::get('/stock/newproduct', [StockController::class, 'create']);

Route::post('/stock/newproduct', [StockController::class, 'store']);

Route::get('/stock/addstock/{id}', [StockController::class, 'add']);

Route::post('/stock/addstock/{id}', [StockController::class, 'tambah']);

Route::get('/stock/stockrusak/{id}', [StockController::class, 'minus']);

Route::post('/stock/stockrusak/{id}', [StockController::class, 'kurang']);

Route::get('/stock/editproduct/{id}', [StockController::class, 'edit']);

Route::put('/stock/editproduct/{id}', [StockController::class, 'update']);

Route::delete('/stock/{id}',[StockController::class, 'destroy']);

Route::post('/stock/close/{id}', [StockController::class, 'close']);

Route::post('/stock/open/{id}', [StockController::class, 'open']);

Route::get('/stock/print', [StockController::class, 'print']);

Route::get('/kasir', [HomeController::class, 'kasir']);

Route::get('/kasir/search', [HomeController::class, 'search']);

Route::post('/kasir/getKasir', [HomeController::class, 'getKasir']);

Route::patch('/kasir/update', [HomeController::class, 'update']);

Route::post('/kasir/store', [HomeController::class, 'store']);

Route::delete('/kasir/delete/{id}', [HomeController::class, 'destroy']); 

Route::patch('/kasir/activate/{id}', [HomeController::class, 'activate']);

Route::patch('/kasir/inactivate/{id}', [HomeController::class, 'inactivate']);

Route::get('/instock', [StockController::class, 'instock']);

Route::delete('/instock/delete/{id}', [StockController::class, 'instockDelete']);

Route::get('/outstock', [StockController::class, 'outstock']);

Route::delete('/outstock/delete/{id}', [StockController::class, 'outstockDelete']);

Route::get('/outstock/detail/{id}', [StockController::class, 'detailoutstock']);

Route::post('/instock/print', [StockController::class, 'printInstock']);

Route::get('/broken', [StockController::class, 'broken']);

Route::delete('/broken/delete/{id}', [StockController::class, 'brokenDelete']);

Route::post('/broken/print', [StockController::class, 'brokenPrint']);

Route::get('/logout',function(){

    auth()->logout();

    if(session('status'))
    {
        $status = session('status');

        return Redirect::to('/login')->with('status', $status);
    }

    return Redirect::to('/login');
    
})->name('logout');

Route::get('/register', function(){

    return Redirect::to('/login');
})->name('register');

