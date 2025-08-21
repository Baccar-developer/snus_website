<?php

namespace App\Http\Controllers;

use App\Models\admins;
use App\Models\orders;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Traits\Date;
use DateTime;
use function GuzzleHttp\json_encode;


class AdminsController extends Controller
{
    public function login(Request $request){
        $admin = admins::where('name' , $request->name)->first();
        if($admin && Hash::check($request->password , $admin->password)){
            Auth::guard("admin")->login($admin);
            return redirect()-> route('dashboard');
        }
        else{
            return back()->withErrors(["password"=>"unfound couple of name and password"]);
        }
    }
    public function log_out(){
        Auth::guard('admin')->logout();
        return redirect("/admin_login");
    }
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        date_default_timezone_set("Africa/Tunis");
        $orders = orders::where("payed" ,1);
        
        $o = clone $orders;
        $month_begin = new DateTime();
        date_modify($month_begin, "-".$month_begin->format("d")." days");
        $month_begin = date_time_set($month_begin, 8, 0);
        
        $previous_month = clone $month_begin;
        date_modify($previous_month, "-1 months");
        
        $p_previous_month = clone $previous_month;
        date_modify($p_previous_month, "-1 months");
        
        $gains_this_month = $o->where("created_at" ,">" ,$month_begin->format("Y-m-d h:i:s"))->sum("price_per_DT");
        
        
        $o = clone $orders;
        $gains_pervious_month = $o->where("created_at" ,">", $previous_month->format("Y-m-d h:i:s"))
        ->where("created_at" ,'<' ,$month_begin->format("Y-m-d h:i:s"))->sum("price_per_DT");
        
        
        $o = clone $orders;
        $gains_p_pervious_month = $o->where("created_at" ,">", $p_previous_month->format("Y-m-d h:i:s"))
        ->where("created_at" ,'<' ,$previous_month->format("Y-m-d h:i:s"))->sum("price_per_DT");

        $orders_this_month= orders::where("created_at" , ">" , $month_begin->format("Y-m-d h:i:s"))->count();
        
        $order_previous_month = orders::where("created_at" ,">" ,$previous_month->format("Y-m-d h:i:s"))->where("created_at" ,"<" ,$month_begin->format("Y-m-d h:i:s"))->count();
        
        return view("admin_pages.dashboard", compact("orders" ))->with([
            "this_month_gains"=>$gains_this_month,
            "previous_month_gains" =>$gains_pervious_month,
            "p_previous_month_gains" =>$gains_p_pervious_month,
            
            "this_month_orders" =>$orders_this_month,
            "previous_month_orders"=>$order_previous_month
        ]);
    }

    
}
