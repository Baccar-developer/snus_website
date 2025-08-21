<?php

namespace App\Http\Controllers;

use App\Models\orders;
use App\Models\chart_elements;
use App\Models\charts;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use function GuzzleHttp\json_encode;

use App\Mail\facture;
use App\Mail\delivered_mail;
use App\Mail\payed;

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
        ->select("orders.created_at" , "location" ,"order_id" , "orders.chart_id" ,"price_per_DT" ,
            "order_status" ,"orders.payed" ,"tel" ,"delivered_at" ,"customer_name" ,"avatar")
        ->orderBy("orders.created_at", "desc")
        
        ->paginate(10);
        return view('admin_pages.dashboard_orders', compact("data") );
    }
    
    
    public function filter(Request $request ,int $page=0){
        $data = orders::leftJoin("charts" , "charts.chart_id" ,"=" ,"orders.chart_id")
        ->leftJoin("users" ,"users.id" ,"=" ,"charts.customer_id")
        ->where("customer_name" ,"LIKE" ,$request->name."%");
        
        
        if($request->status =="delivered"){
            $data->where("order_status","delivered")->orderBy("orders.payed" ,"asc");
        }
        else if($request->status =="unfulfilled"){
            $data->where("order_status","unfulfilled")->orderBy("orders.payed" ,"asc");
        }
        else if($request->status ="canceled"){
            $data->where("order_status","canceled");
        }
        
        $date_order = "asc";
        $price_order = "asc";
        
        if($request->date_order){$date_order = "desc";}
        if($request->price_order){$price_order = "desc";}
        $data->orderBy("orders.created_at" ,$date_order)->orderBy("orders.price_per_DT",$price_order);
        $data = $data
        ->select("orders.created_at" , "location" ,"order_id" , "orders.chart_id" ,"price_per_DT" ,
            "order_status" ,"orders.payed" ,"tel" ,"delivered_at" ,"customer_name" ,"avatar");
        
        $parameters = ["status" =>$request->status , "date_order"=>$request->date_order ,"price_order"=>$request->price_order ,"name"=>$request->name];
        $data=$data->paginate(10);
        $data->append($request->query());
        return view("admin_pages.dashboard_orders" ,compact("data"))->with($parameters);
        
    }

    public function previous_orders(){
        $orders = orders::join("charts as c" ,'c.chart_id' ,'=' , 'orders.chart_id')->where("customer_id" ,Auth::id())
        ->where(function($query){
            $query->where(["payed" =>false ,"order_status"=>"delivered"])
            ->orWhere("order_status" , "unfulfilled");
        }
        )
        ->orderBy("orders.created_at" ,"desc")->limit(2)
        ->get( ["orders.created_at" , "price_per_DT" , "order_status" ,'payed','orders.chart_id',"order_id" ,"location"]);

        return view("auth.orders" ,compact("orders" ));
    }
    
    public function scroll(Request $request){
        $orders = orders::join("charts as c" ,'c.chart_id' ,'=' , 'orders.chart_id')->where("customer_id" ,Auth::id())
        ->where(function($query){
            $query->where(["payed" =>false ,"order_status"=>"delivered"])
            ->orWhere("order_status","unfulfilled");
        })
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
        ->get(["chart_elements.product_id" ,"qnt" , "price_per_DT" ,"product_name"]);
        
        
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
            
            if(Auth::user()->email){
                Mail::to(Auth::user()->email)->sendNow(new facture($chart_elements, $request->price_per_DT));
            }
            
            foreach ($chart_elements as $c) {
                $product=products::where("product_id" , $c->product_id)->first();
                products::where("product_id" , $c->product_id)->update(["ordered_qnt" => $product->ordered_qnt+$c->qnt, "wished_qnt"=>$product->wished_qnt-$c->qnt]);
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
            $p = clone $product;
            $new_qnt = $p->first()->ordered_qnt - $c->qnt;
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
        $order =orders::where("order_id" , $request->order_id);
        $cng = $order->update(["payed" => 1]);
        if($cng){
            
            $email = $order->leftJoin("charts" ,"charts.chart_id" ,"=" ,"orders.chart_id")
            ->leftJoin("users" ,"users.id" , '=' ,"charts.customer_id")->first()->email;
            if($email){
                Mail::to($email)->sendNow(new payed($order->first()->created_at));
            }
            return back()->with("msg" ,"update is done with success");
        }
        else{ return back()->withErrors("some server errors");}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function check(Request $request){
        
        date_default_timezone_set("Africa/Tunis");
        $order = orders::where("order_id" ,$request->order_id);
        $payed =false;
        if($request->payed=='on'){$payed = true;}
        $order->update(["order_status"=>"delivered" , "payed"=>$payed , "delivered_at" =>date('Y-m-d H:i:s')]);

        $chart_elements =chart_elements::where("chart_id" , $order->first()->chart_id)->get(["product_id" ,"qnt"]);
        foreach ($chart_elements as $c){
            $product = products::where("product_id" ,$c->product_id);
            $product->decrement("full_qnt" , $c->qnt);
            $product->decrement("ordered_qnt" , $c->qnt);
        }
        $email = $order->leftJoin("charts" ,"charts.chart_id" ,"=" ,"orders.chart_id")
        ->leftJoin("users" ,"users.id" , '=' ,"charts.customer_id")->first()->email;
        if($email){
            Mail::to($email)->sendNow(new delivered_mail($payed));
        }
        return back()->with("msg" , "order is checked");
    }
    
    public function destroy(Request $request)
    {
        orders::where('order_id' ,$request->order_id)->delete();
        return back()->with("msg" , "deletion done with sucess");
        
    }
}
