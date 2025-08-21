<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\SmsController;
use App\Models\User;
use App\Models\charts;
use App\Models\chart_elements;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use function GuzzleHttp\json_encode;
use Illuminate\Validation\Rules\Password;


use App\Mail\emailValidationMailer;
use App\Mail\accountVerifMail;
use Vtiful\Kernel\Chart;


class UsersControler extends Controller
{
    public function tel_confirm(UsersRequest $request){
        $tel =str_replace(' ', '', $request->tel);
        if(User::where("tel" , $tel)->exists() ){
            return redirect('/signup')->withErros(["num_exists" =>"this phone number is used already"]);
        }
        $password = Hash::make($request->password);
        $name = $request->name;
        $code = (string)rand(100000 , 999999);
        SmsController::sendSMS($tel , $code);
        return view("verification.tel_verif")->with(["tel"=>$tel , "password"=>$password ,"code"=>Hash::make($code) , "name"=>$name]);
    }
    
    public function signup(Request $request){
        $answer = $request->digit_1.$request->digit_2.$request->digit_3.$request->digit_4.$request->digit_5.$request->digit_6;
        if (!Hash::check($answer,$request->code)){
            return back()->withErrors( "wrong code");
        }
        
        User::insert([
            "customer_name"=>$request->name,
            "tel"=>$request->tel,
            "password"=>$request->password,
        ]);
        charts::insert(["customer_id"=>User::where("tel", $request->tel)->first()->id]);
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
            if($request->remember=='on'){
                $remeber_tocken=Str::random(10);
                Cookie::queue('user_tocken', $remeber_tocken, getenv('COOKIE_LIFETIME'));
                $user->update(["remember_token" =>$remeber_tocken] );
            }
            
            Auth::login($inv);
            return redirect('/profile')->with("msg" , "you logued in with sucess ,".$inv->customer_name);
        }
        return back()->withErrors( "unmatcing password");   
    }
    
    public function profile(){
        $last_order= charts::where("customer_id" , Auth::id())->Join("orders" , "orders.chart_id" , "=" ,"charts.chart_id")->orderBy("orders.created_at" ,"desc")->first();
        if(!$last_order){
            return view("auth.profile");
        }
        
       
        return view("auth.profile", compact('last_order' ));
    }
    
    public function verif_email(Request $request){
        $request->validate(["email"=>"required|email"]);
        $exists = User::where("email",$request->email)->exists();
        if($exists){
            return back()->withErrors("this email is already used");
        }
        $code =Str::random(6);
        Mail::to($request->email)->send(new emailValidationMailer($code));
        return view("verification.email_verif")->with(["code" =>Hash::make($code) ,"email"=>$request->email]);
    }
    
    public function change_email(Request $request){
        if(!Hash::check($request->verif ,$request->code)){
            return redirect('/profile/change_email')->withErrors("wrong code!");
        }
        User::where("id" ,Auth::id())->update(["email" =>$request->email]);
        return redirect()->route('profile')->with("msg" ,"email is validated 👍");
        
    }
    
    public function update_avatar(Request $request){
        $request->validate(
               ["image"=>"required|min:10|max:960|mimes:png,jpeg,webp"]
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
        ->leftJoin("products as p" , "p.product_id" ,"=" ,"chart_elements.product_id");
        $price =0;
        foreach($cart_elements->get() as $p){
            $price += $p->price_per_DT* $p->qnt;
        }
        $cart_elements = $cart_elements->paginate(10);
        return view('auth.current_cart' ,compact("cart" , "cart_elements"))->with("price",$price);
    }
    
    public function restore_code(Request $request){
        $request->validate(["tel_or_email" => "required"]);
        $tel_or_email = $request->tel_or_email;
        $tel_or_email= str_replace(" ", "", $tel_or_email);
        $tel_or_email= str_replace(")", "", $tel_or_email);
        $tel_or_email= str_replace("(", "", $tel_or_email);
        $tel_or_email= str_replace("-", "", $tel_or_email);
        $user;
        if(strpos($request->tel_or_email ,"@")==null){
            $user =User::where("tel" , $tel_or_email)->first();
        }
        else{
            $user =User::where("email" , $tel_or_email)->first();
        }
        if(!$user){
            return back()->withErrors("this email or telephone num isn't valid in this site");
        }
        $code =Str::random();
        $data =["code"=>Hash::make($code)];
        if(strpos($tel_or_email, '@')==null){
            $data["tel"] =$tel_or_email;
            SmsController::sendSMS($tel_or_email, "your verification code:\n".$code);
        }
        else{
            
            $data["email"] =$tel_or_email;
            Mail::to($tel_or_email)->sendNow(new accountVerifMail($code));
            
        }
        return view("verification.restore_verif")->with($data);
    }
    
    public function reset_password_form(Request $request){
        if(!Hash::check($request->verif, $request->code)){
            return redirect("/restore_account")->withErrors("wrong verification code!");
        }
        return view("verification.reset_password_form")->with([
            "email" =>$request->email,
            "tel"=>$request->tel
        ]);
    }
    
    public function reset_password(Request $request){
        $request->validate([
            "password"=>Password::default(function(){
                        return Password::min(12)
                        ->letters()
                        ->numbers()
                        ->symbols()
                        ->mixedCase()
                        ->uncompromised();}),
            "confirm-password" =>"same:password"
        ]);
        $user;
        if($request->email){
            $user = User::where("email" ,$request->email);
        }
        else{
            $user = User::where("tel" ,$request->tel);
        }
        
        $user->update(["password" =>Hash::make($request->password)]);
        Auth::login($user->first());
        return redirect()->route('profile')->with("msg" , "welcome" .Auth::user()->customer_name.",password changed with success");
        
    }
}
