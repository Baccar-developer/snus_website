<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\OrdersController;


Route::get('/', function () {
    return view('home');
});
Route::get('/AboutUs', function () {
    return view('about');
});
Route::middleware([AdminMiddleware::class])->group(function(){
    Route::get('/dashboard/products' ,[ProductsController::class ,'index']
    )->name('dashboard');
    Route::get('/dashboard/orders' ,[OrdersController::class ,'index']
    )->name('orders_dashboard');
    
        
});


Route::get('/not_autorized' , function(){
    return view("not_authenticated");
});

Route::get('/admin_login' , function(){
    return view("admin_login");
});

Route::post('/AdminsController' , [AdminsController::class , 'login']);