<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;

class Eshop extends Controller
{
    public function display_products(){
        $data = products::orderBy("created_at" ,"desc")->paginate(10);
        return view("shop" , compact("data"));
    }
}
