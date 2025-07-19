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
    
    Route::delete("/dashboard/products/delete" , [ProductsController::class, "destroy"])->name('delete_product');
    Route::post("/dashboard/products/modify" , [ProductsController::class, "update"])->name('modify_product');
    Route::get("/dashboard/products/add_page" , function(){
        return view("admin_pages.product_add")->with(["name"=>auth('admin')->name]);
    })->name('product_add_page');
    Route::post("/dashboard/products/add" ,[ProductsController::class ,"store"])->name("add_product");
    
    Route::get('/admin_logout' , [AdminsController::class ,'log_out'])->name('disconnect_admin');
        
});


Route::get('/not_autorized' , function(){
    return view("not_authenticated");
});

Route::get('/admin_login' , function(){
    return view("admin_pages.admin_login");
});

Route::post('/AdminsController' , [AdminsController::class , 'login']);