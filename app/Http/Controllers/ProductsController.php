<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\View;
use App\Models\products;
use App\Models\orders;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use function GuzzleHttp\json_encode;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = products::orderBy("created_at" ,"desc")->paginate(10);
        return view('admin_pages.dashboard_products' )->with(["data"=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
        {
        if(products::where("product_name" ,$request->product_name)->exists()){
            return back()->withErrors(["not unique"=>"the product_name '$request->product_name' already exists"]);
        }
        $product = [
            "product_name"=>$request->product_name,
            "product_desc"=>$request->product_desc,
            "price_per_DT"=>$request->price_per_DT,
            "full_qnt"=>$request->full_qnt,
        ];
        if($request->file('image')){
            $new_product_name = $request->file('image')->hashName();
            Storage::disk("public")->putFileAs("product_img" , $request->file('image')  ,$new_product_name );
            $product['product_image'] = $new_product_name;
        }
       products::insert($product);
       return redirect()->route("products_dashboard")->with(["msg"=>"insertion is done with success"]);
    }
    
    
    public function filter(Request $request){
        $rate_ord ="desc";
        $date_ord ="desc";
        if(!$request->rate_order){$rate_ord="asc";}
        if(!$request->date_order){$date_ord="asc";}
        $data =products::where("product_name", "LIKE", $request->name."%")
        ->orderBy("created_at" , $date_ord)
        ->orderBy("product_rate" , $rate_ord)
        ->paginate(10);
        
        $data->appends(request()->query());
        
        
       return  view('admin_pages.dashboard_products')->with(["data"=>$data]);
        
    }
    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(products $products)
    {
       
    }
    function description_modify(Request $request){
        $product = products::where("product_id",$request->id);
        $cng = $product->update(["product_desc" => $request->desc]);
        if($cng){
            return back()->with("msg" , "the description is modified");
        }
        return back()->withErrors("modification failed!");
    }
    
    public function update(ProductRequest $request)
    {
        $product = products::where("product_id" , $request->product_id)->first();
        $new= [];
        if($request->hasFile("image")){
            if($product->product_image && Storage::disk("public")->exists("product_img/".$product->product_image)){
                
                Storage::disk("public")->delete("product_img/".$product->product_image);
            }
            $file =$request->file('image');
            
            $new_product_name=$file->hashName();
            Storage::disk("public")->putFileAs("product_img" , $request->file("image") ,$new_product_name );
            $new = ["product_image" => $new_product_name];
        }
        $new =array_merge($new ,
            [
                "product_name"=>$request->product_name,
                "full_qnt"=>$request->full_qnt,
                "price_per_DT"=>$request->price_per_DT
            ]);
        products::where("product_id" ,$request->product_id)->update($new);
        return back()->with("msg","the updates are done with success");
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request)
    {
        $product =products::where("product_id" ,$request->id);
        Storage::disk('public')->delete("product_img/".$product->first()->product_image);
        $cng = $product->delete();
        if($cng){
            return back()->with("msg" , "deleion done with success!");
        }
        else{
            return back()->withErrors("failed to delete ☹️");
        }
    }
}
