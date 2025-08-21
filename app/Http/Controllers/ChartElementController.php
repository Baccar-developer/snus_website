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
                $product->update(["wished_qnt" => $new_qnt]);
                return back()->with("msg", "deletion done with sucess!");
            }
            return back()->withErrors(["undeleted" , "deletion failed!"]);
        }
    }
    
    public function create(Request $request ,int $product_id){
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
            return back()->with("msg" , "product added to cart");
        }
        else{
            return back()->withErrors("adding product to cart is failed");
        }
    }
    
    public function chart_elements_list(Request $request){
        try {
            $data = chart_elements::where("chart_elements.chart_id", $request->chart_id)
            ->leftJoin("products", "products.product_id", "=", "chart_elements.product_id")
            ->select(
                "products.product_name",
                "products.product_image",
                "chart_elements.qnt",
                "products.price_per_DT"
                )
                ->paginate(10); // Changed from 1 to 10 for practical pagination
                $data->append($request->query());
                if ($request->ajax()) { // Fixed: using $request->ajax() not $request()
                    return response()->json([
                        'html' => view("includes.items_list", compact("data"))->render(),
                        'links' => $data->withQueryString()->links()->toHtml() // Using toHtml() instead of render()
                    ]);
                }
                
                return view("includes.items_list", compact("data"));
                
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Chart data error: ' . $e->getMessage());
            
            // Return proper error response
            return $request->ajax()
            ? response()->json(['error' => 'Server error'], 500)
            : back()->with('error', 'Failed to load data');
        }
    }
}
