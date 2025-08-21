<?php

namespace App\Http\Controllers;

use App\Models\reviews;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function user_reviews(){
        $reviews = reviews::where("customer_id" , Auth::id())->orderBy("reviews.created_at","desc")->limit(4);
        $reviews = $reviews->leftJoin("products as p" , "p.product_id", "=" , "reviews.product_id")
        ->get(["product_name" , "product_image" , "product_rate" , "rate" , "comment", "reviews.product_id" , "reviews.created_at","product_desc" ]);
        
        return view("auth.user_reviews" ,compact("reviews"));
        
    }
    
    public function user_reviews_scroll(Request $request ){
        $reviews = reviews::where("customer_id" , Auth::id())->offset($request->start)->orderBy("reviews.created_at","desc")->limit($request->step);
        $reviews = $reviews->leftJoin("products as p" , "p.product_id", "=" , "reviews.product_id")
        ->get(["product_name" , "product_image" , "product_rate" , "rate" , "comment", "reviews.product_id" , "reviews.created_at","product_desc" ]);
        
        return view("includes.user_reviews" ,compact("reviews"));
    }
    
    public function product_reviews(int $product_id){
        $product =products::where('product_id',$product_id)->first();
        $reviews = reviews::where("reviews.product_id" , $product_id)->orderBy("reviews.created_at","desc")->limit(4);
        $reviews = $reviews->leftJoin("users" ,"users.id" ,'=' ,'reviews.customer_id')
        ->get(["customer_id" ,"avatar" ,"customer_name" ,"rate" ,"comment" ,"reviews.created_at" ]);
        return view("product_reviews" ,compact('reviews'))->with("product" ,$product);
    }
    public function product_reviews_scroll(int $product_id ){
        $reviews = reviews::where("product_id" , $product_id)->offset($request->start)->limit($request->step);
        $reviews = $reviews->leftJoin("users" ,"users.id" ,'=' ,'reviews.customer_id')
        ->get(["customer_id" ,"avatar" ,"customer_name" ,"rate" ,"comment" ,"reviews.created_at"]);
        return view("includes.product_reviews" ,compact('reviews'));
    }
    
    public function create( Request $request){
        
        $chng =reviews::insert([
            "product_id"=>$request->product_id,
            "customer_id"=>Auth::id(),
            "rate"=>$request->rate,
            "comment"=>$request->comment,
        ]);
        if(!$chng){
            return back()->withErrors("this review isn't sent");
        }
        else{
            $product = products::where("product_id" ,$request->product_id)->first();
            $rate = ($product->product_rate * $product->ratings+ $request->rate)/($product->ratings+1);
            $chng = products::where("product_id" , $request->product_id)->update(["ratings" =>$product->ratings+1 ,"product_rate"=>$rate]);
            if ($chng){return back()->with("msg" , "your review is sent!");}
            else{return back()->withErrors("the product general rate isn't updated");}
        }
        
    }
    
}
