<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleWare;
use App\Http\Middleware\GestMiddleware;

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\Eshop;
use App\Http\Controllers\UsersControler;
use App\Http\Controllers\ChartElementController;
use App\Http\Controllers\ReviewsController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


Route::get("/shop" ,[Eshop::class , "display_products"]);

Route::get("/restore_account" , function(){
    return view("verification.account_restore");
});
Route::post("/restore_account/validation" , [UsersControler::class , 'restore_code'])->name("account_validation");
Route::get("/reset_password" ,[UsersControler::class , 'reset_password_form']);

Route::put("/reset_password/reset" ,[UsersControler::class , 'reset_password'])->name("reset_password");

Route::middleware([AdminMiddleware::class])->group(function(){
    Route::get('/admin/products' ,[ProductsController::class ,'index']
    )->name('dashboard');
    
    Route::get("/admin/products/search" ,[ProductsController::class , "filter"]);
    Route::get('/admin/orders' ,[OrdersController::class ,'index']
    )->name('orders_dashboard');
    
    Route::delete("/admin/products/delete" , [ProductsController::class, "destroy"])->name('delete_product');
    Route::post("/admin/products/modify" , [ProductsController::class, "update"])->name('modify_product');
    Route::get("/admin/products/add_page" , function(){
        return view("admin_pages.product_add");
    })->name('product_add_page');
    Route::post("/admin/products/add" ,[ProductsController::class ,"store"])->name("add_product");
    
    Route::get('/admin_logout' , [AdminsController::class ,'log_out'])->name('disconnect_admin');
       
    Route::delete("/admin/orders/delete" , [OrdersController::class, "destroy"])->name('delete_order');
    Route::patch("/admin/orders/check" , [OrdersController::class, "check"])->name('check_order');
    
    Route::post("/admin/orders/filter" ,[OrdersController::class ,"filter"]);
    
    Route::patch("/admin/orders/is_payed" ,[OrdersController::class ,'payed'])->name("is_payed");
});

Route::middleware([GestMiddleware::class])->group(function(){
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/about_us', function () {
        return view('about');
    });
    
  Route::get('/not_autorized' , function(){
     return view("not_authenticated");
   });
        
   Route::get('/admin_login' , function(){
      return view("admin_pages.admin_login");
   });
            
   
                
   Route::get('/signup' ,function(){
      return view("signup");
    });
   Route::get('/login' ,function(){
       return view("login");
   });
   
       Route::get("/reviews/{product_id}" , [ReviewsController::class ,'product_reviews'])->name("product_reviews");
       Route::get("/reviews/scroll/{product_id}" , [ReviewsController::class ,'product_reviews_scroll']);
   
});
        

Route::post('/signup/verif_tel' ,[UsersControler::class ,'tel_confirm'])->name('verif_tel');
Route::post('/signup/add_user' ,[UsersControler::class ,'signup'])->name('add_user');
Route::post('/login/login_user' , [UsersControler::class , 'login'])->name("login_user");



Route::middleware(AuthMiddleWare::class)->group(function(){
    Route::get('/profile', [UsersControler::class , 'profile'])->name("profile");
    Route::patch('/profile/update_avatar' ,[UsersControler::class , 'update_avatar'] )->name("change_avatar");
    
    Route::get("/profile/change_email" , function(){
        return view("verification.email");
    })->name("change_email_form");
    
    Route::post('profile/verif_email' , [UsersControler::class , 'verif_email'])->name("verif_email");
    Route::get('profile/cart' , [UsersControler::class , 'current_cart'])->name("current_cart");
    
    Route::post("profile/cart/modify" ,[ChartElementController::class ,'modify'] )->name("modify_cart");
    
    Route::post("profiel/cart/send_order" ,[OrdersController::class , "store"])->name("send_order");
    Route::patch("profile/orders/cancel_order", [OrdersController::class , "cancel"])->name('cancel_order');
    Route::get("profile/orders" , [OrdersController::class , 'previous_orders'])->name("user_orders");
    
    Route::post("profile/orders/scroll" , [OrdersController::class , 'scroll']);
    
    Route::get('profile/reviews' , [ReviewsController::class , 'user_reviews'])->name("user_reviews");
    Route::post('profile/reviews/scroll' , [ReviewsController::class , 'user_reviews_scroll']);
    Route::post('/reviews/send_review' , [ReviewsController::class , 'create'])->name("rate_product");
    
    Route::get("shop/add_to_cart/{product_id}" , [ChartElementController::class , "create"])->name("add_to_cart");

    
    Route::patch('profile/email_email' , [UsersControler::class , 'change_email'])->name("change_email");
    Route::get("/logout", function(){
        Auth::logout();
        Cookie::forget("user_tocken");
        return redirect('/')->with("msg", "you logued out ");
    });
});
    


Route::post('/AdminsController' , [AdminsController::class , 'login']);