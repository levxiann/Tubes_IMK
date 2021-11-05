<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReceiptController;
use App\Models\Receipt;
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

Route::get('/invoice', [ReceiptController::class, 'invoice']);

Route::get('/home', [HomeController::class, 'index'])->name('home');

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