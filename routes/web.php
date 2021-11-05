<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\StockController;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');

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