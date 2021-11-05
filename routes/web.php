<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DiscountController;
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

Route::get('/discount', [DiscountController::class, 'index'])->name('discount');
Route::patch('/discount/update', [DiscountController::class, 'update']);
Route::post('/discount/getDiscountDetail', [DiscountController::class, 'getDetail']);
Route::delete('/discount/delete/{id}', [DiscountController::class, 'destroy']);

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

