<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;

class Eshop extends Controller
{
    public function display_products(){
        $data = products::orderBy("created_at" ,"desc")->paginate(10);
        $date =date_sub(now() ,date_interval_create_from_date_string("7 days"));
        $best =products::where("created_at" ,">" ,$date->format("Y-m-d h:i:m") );
        if(!$best->exists()){
            $best = products::where("product_rate" ,">" , products::max("product_rate")-0.01)->first();
        }
        else{
            $best =$best->first();
        }
        return view("shop" , compact("data" ,"best"));
    }
}
