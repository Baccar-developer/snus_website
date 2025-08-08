<?php

namespace App\Http\Controllers;

use App\Models\orders;
use App\Models\chart_elements;
use App\Models\charts;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\json_encode;


class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = orders::where(["orders.payed"=>false ,"order_status"=> "delivered"])->orWhere("order_status" , "unfulfilled")
        ->leftJoin("charts" , "charts.chart_id" ,"=" ,"orders.chart_id")
        ->leftJoin("users" ,"users.id" ,"=" ,"charts.customer_id")
        ->orderBy("orders.created_at", "desc")
        
        ->paginate(10);
        return view('admin_pages.dashboard_orders' )->with(["data"=>$data]);
    }
    
    
    public function filter(Request $request){
        $data = orders::leftJoin("charts" , "charts.chart_id" ,"=" ,"orders.chart_id")
        ->leftJoin("users" ,"users.id" ,"=" ,"charts.customer_id");
        
        if($request->delivered =="true"){
            $data= $data->where("order_status","delivered");
        }
        else if($request->unfulfilled =="true"){
            $data= $data->where("order_status","unfulfilled");
        }
        else if($request->canceled ="true"){
            $data= $data->where("order_status","canceled");
        }
        
        $date_order = "asc";
        $price_order = "asc";
        
        if($request->date_order){$date_order = "desc";}
        if($request->price_order){$price_order = "desc";}
        $data = $data->orderBy("orders.created_at" ,$date_order)->orderBy("orders.price_per_DT",$price_order)->orderBy("orders.payed" ,"asc");
        if(! $data->first()){ return "<div class='container-fluid f-3 text-center'>no result</div>";}
        
        return view("includes.orders" )->with("data" ,$data->paginate(10));
    }

    public function previous_orders(){
        $orders = orders::join("charts as c" ,'c.chart_id' ,'=' , 'orders.chart_id')->where("customer_id" ,Auth::id())
        ->where(["payed" =>false ,"order_status"=>"delivered"])
        ->orWhere("order_status","unfulfilled")
        ->orderBy("orders.created_at" ,"desc")->limit(2)
        ->get( ["orders.created_at" , "price_per_DT" , "order_status" ,'payed','orders.chart_id',"order_id" ,"location"]);

        return view("auth.orders" ,compact("orders" ));
    }
    
    public function scroll(Request $request){
        $orders = orders::join("charts as c" ,'c.chart_id' ,'=' , 'orders.chart_id')->where("customer_id" ,Auth::id())
        ->where(["payed" =>false ,"order_status"=>"delivered"])
        ->orWhere("order_status","unfulfilled")
        ->orderBy("orders.created_at" ,"desc")
        ->offset($request->start)->limit($request->step)
        ->get( ["orders.created_at" , "price_per_DT" , "order_status" ,'payed','orders.chart_id',"order_id" ]);
        
        if(!$orders->first()){return "";}
        return view("includes.orders_scroll" ,compact("orders" ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate(["location"=>"required"]);
        $chart_elements = chart_elements::where("chart_id" , $request->chart_id)
        ->leftJoin("products as p" ,"p.product_id" ,"=" ,"chart_elements.product_id")
        ->get(["chart_elements.product_id" ,"qnt"]);
        
        
        foreach ($chart_elements as $c){
            $product = products::where("product_id" ,$c->product_id)->get(["product_id" ,"ordered_qnt" ,"full_qnt" ,"product_name"])->first();
            if($c->qnt > $product->full_qnt- $product->ordered_qnt){
                return back()->withErrors("we don't have enougn of ".$product->product_name);
            }
        }
        
        $method =$request->method;
        $payed = 0;
        
        $chng = orders::insert(["chart_id" =>$request->chart_id , "price_per_DT"=>$request->price_per_DT ,'location'=>$request->location,"payed"=>$payed]);
        if($chng){
            foreach ($chart_elements as $c) {
                $product=products::where("product_id" , $c->product_id)->first();
                products::where("product_id" , $c->product_id)->update(["ordered_qnt" => $product->ordered_qnt+$c->qnt, "wished_qnt"=>$product->wished_qnt-$c->qn]);
            }
            charts::insert(["customer_id" => Auth::id()]);
            return back()->with("msg" , "the order is sent with success");
        }
        else{
            return back()->withErrors("this orders isn't sent");
        }
    }

    public function cancel(Request $request ){
        $chn = orders::where("order_id" ,$request->order_id)->update(["order_status" =>"canceled"]);
        if(!$chn){return back()->withErrors("updating error");}
        
        $order=orders::where("order_id" ,$request->order_id)->first();
        $chart_elements= chart_elements::where("chart_id" , $order->chart_id)->get();
        foreach ($chart_elements as $c) {
            $product = products::where("product_id" , $c->product_id);
            $new_qnt = $product->first()->ordered_qnt - $c->qnt;
            $product->update(["ordered_qnt"=>$new_qnt]);
        }
        
        return back()->with("msg" ,"the order is canceled with success!");
    }
    
    public function show(orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function payed(Request $request)
    {
        $cng = orders::where("order_id" , $request->order_id)->update(["payed" => 1]);
        if($cng){return back()->with("msg" ,"update is done with success");}
        else{ return back()->withErrors("some server errors");}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function check(Request $request){
        $order = orders::where("order_id" ,$request->order_id);
        $order->update(["order_status"=>"delivered" , "payed"=>$request->payed , "delivered_at" =>date('Y-m-d H:i:s')]);
        return back()->with("msg" , "order is checked");
    }
    
    public function destroy(Request $request)
    {
        orders::where('order_id' ,$request->order_id)->delete();
        return back()->with("msg" , "deletion done with sucess");
        
    }
}
