<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\SmsController;
use App\Models\User;
use App\Models\charts;
use App\Models\orders;
use App\Models\chart_elements;
use App\Models\products;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use function GuzzleHttp\json_encode;


use App\Mail\emailValidationMailer;


class UsersControler extends Controller
{
    public function tel_confirm(UsersRequest $request){
        $tel =str_replace(' ', '', $request->tel);
        if(User::where("tel" , $tel)->exists() ){
            return back()->withErros(["num_exists" =>"this phone number is used already"]);
        }
        $password = Hash::make($request->password);
        $name = $request->name;
        $code = (string)rand(100000 , 999999);
        SmsController::sendSMS($tel , $code);
        return view("verification.tel_verif")->with(["tel"=>$tel , "password"=>$password ,"code"=>$code , "name"=>$name]);
    }
    
    public function signup(Request $request){
        $answer = $request->digit_1.$request->digit_2.$request->digit_3.$request->digit_4.$request->digit_5.$request->digit_6;
        if ($answer != $request->code){
            return back()->withErrors("wrong code", "wrong code");
        }
        User::insert([
            "customer_name"=>$request->name,
            "tel"=>$request->tel,
            "password"=>$request->password,
        ]);
        return redirect('/login')->with("msg" , "signup done with success");
        
    }
    
    public function login(Request $request){
        $email_or_tel =$request->email_or_tel;
        $user;
        if(strpos($email_or_tel , '@') !=null){
            $user = User::where("email" , $email_or_tel);
            if(!$user->exists()){
                return back()->withErrors(["inexistante" =>"this email doesn't exists"]);
            }
        }
        else{
            $email_or_tel=str_replace(' ', '', $email_or_tel);
            $email_or_tel=str_replace('-', '', $email_or_tel);
            $email_or_tel=str_replace('(', '', $email_or_tel);
            $email_or_tel=str_replace(')', '', $email_or_tel);
            if(substr($email_or_tel , 0,1)!='+'){
                $email_or_tel ='+'.$email_or_tel;
            }
            $user = User::where("tel" , $email_or_tel);
            if(!$user->exists() ){
                return back()->withErrors(["inexistante_num" =>"this number doesn't exists "]);
            }
        }
        $inv = $user->first();
        if(Hash::check($request->password, $inv->password)){
            if($request->remember){
                $remeber_tocken=Str::random(10);
                Cookie::queue('user_tocken', $remeber_tocken, getenv('COOKIE_LIFETIME'));
                $user->update(["remember_token" =>$remeber_tocken] );
            }
            
            Auth::login($inv);
            return redirect('/profile')->with("msg" , "you loged in with sucess ,".$inv->customer_name);
        }
        return back()->withErrors("password unmatch" , "unmatcing password");   
    }
    
    public function profile(){
        $last_order= charts::where("customer_id" , Auth::id())->Join("orders" , "orders.chart_id" , "=" ,"charts.chart_id")->orderBy("orders.created_at" ,"desc")->first();
        if(!$last_order){
            return view("auth.profile");
        }
        $purchases = chart_elements::where("chart_id" ,$last_order->chart_id)->leftJoin("products","products.product_id" ,'=' , "chart_elements.product_id")->orderBy("chart_elements.created_at" ,"desc")->get();
        return view("auth.profile", compact('last_order' ,'purchases'));
    }
    
    public function verif_email(Request $request){
        $request->validate(["email"=>"required|email"]);
        $code =Str::random(6);
        Mail::to($request->email)->send(new emailValidationMailer($code));
        return view("verification.email_verif")->with("code" ,$code);
    }
    
    public function change_email(Request $request){
        return "doen";
    }
    
    public function update_avatar(Request $request){
        $request->validate(
               ["image"=>"required|min:10|max:960"]
            );
        if(Auth::user()->avatar){
            Storage::disk("public")->delete("profile_img/".Auth::user()->avatar);
        }
        
        $image_name = $request->file('image')->hashName();
        Storage::disk("public")->put("profile_img", $request->file('image')  );
        User::find(Auth::id())->update(["avatar"=>$image_name]);
        return back()->with("msg" , "changing avatar is done with sucess");
    }
    
    public function current_cart(){
        $cart = charts::where("customer_id","=" , Auth::id())->orderBy("created_at" , 'desc')->first();
        if(!$cart){
            charts::insert(["customer_id" => Auth::id()]);
        }
        $cart_elements = chart_elements::where("chart_id" , $cart->chart_id)
        ->leftJoin("products as p" , "p.product_id" ,"=" ,"chart_elements.product_id")->paginate(10);
        $price =0;
        foreach($cart_elements as $p){
            $price += $p->price_per_DT* $p->qnt;
        }
        return view('auth.current_cart' ,compact("cart" , "cart_elements"))->with("price",$price);
    }
}
