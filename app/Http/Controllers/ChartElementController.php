<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\chart_elements;
use App\Models\charts;
use Illuminate\Support\Facades\Auth;
use App\Models\products;

class ChartElementController extends Controller
{
    public function modify(Request $request){
        $chart_element = chart_elements::where("chart_id" ,$request->chart_id)->where("product_id" , $request->product_id);
        if($request->has("modify")){
            
            $product = products::where("product_id" , $chart_element->first()->product_id);
            $new_qnt = $product->first()->wished_qnt - $chart_element->first()->qnt +$request->qnt;
            $chng = $chart_element->update(["qnt"=> $request->qnt]);
            if($chng){
                $product->update(["wished_qnt"=> $new_qnt]);
                return back()->with("msg", "modification done with sucess!");
            }
            return back()->withErrors(["unchanged" , "modification failed!"]);
            
        }
        else if($request->has("delete")){
            
            $product = products::where("product_id" , $chart_element->first()->product_id);
            $new_qnt = $product->first()->wished_qnt - $chart_element->first()->qnt ;
            $chng =$chart_element->delete();
            if($chng){
                return back()->with("msg", "deletion done with sucess!");
            }
            return back()->withErrors(["undeleted" , "deletion failed!"]);
        }
    }
    
    public function create(int $product_id){
        $cart = charts::where("customer_id" , Auth::id())->orderBy("created_at", "desc")->first();
        if(!$cart){
            $cart = charts::insert(["customer_id"=>Auth::id()]);
        }
        $similar = chart_elements::where("product_id" ,$product_id)->where("chart_id" , $cart->chart_id)->first();
        if($similar){
            return back()->withErrors("already exists in cart");
        }
        
        $cng=chart_elements::insert(["product_id"=> $product_id , "chart_id" => $cart->chart_id , "qnt"=>1]);
        if ($cng){
            products::where("product_id" , $product_id)->increment("wished_qnt" ,1);
            return back()->with("msg" , "prosuct added to cart");
        }
        else{
            return back()->withErrors("adding product to cart is failed");
        }
    }
}
