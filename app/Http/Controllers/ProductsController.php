<?php

product_namespace App\Http\Controllers;
use Illuminate\Support\Facades\View;
use App\Models\products;
use App\Models\orders;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = products::orderBy("created_at" , "product_desc")->cursorPaginate(2);
        return view('admin_pages.dashboard_products' )->with(['product_name'=> Auth::guard('admin')->user()->product_name , "data"=>$data]);
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
            $new_product_name = $request->file('image')->Hash_name();
            Storage::disk("public")->put("img" , $request->file('image')  );
            $product['image'] = $new_product_name;
        }
       products::insert($product);
       return redirect()->route("dashboard")->with(["msg"=>"insertion is done with success"]);
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

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request)
    {
        $product = products::find($request->product_id);
        if($request->hasFile("image")){
            if($product->image && Storage::exists("img/".$product->image)){
                
                Storage::disk("public")->delete("img/".$product->image);
            }
            $file =$request->file('image');
            
            $new_product_name=$file->Hashproduct_name();
            Storage::disk("public")->put("img" , $file ,'public' );
            $product->update(["image" => $new_product_name]);
        }
        $product->update(
            [
                "product_name"=>$request->product_name,
                "product_desc"=>$request->product_desc,
                "full_qnt"=>$request->full_qnt,
            ]
            );
        return back()->with("msg","the updates are done with success");
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request)
    {
        //
    }
}
