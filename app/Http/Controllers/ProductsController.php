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


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = products::orderBy("created_at" , "desc")->cursorPaginate(2);
        return view('admin_pages.dashboard_products' )->with(['name'=> Auth::guard('admin')->user()->name , "data"=>$data]);
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
        if(products::where("name" ,$request->name)->exists()){
            return back()->withErrors(["not unique"=>"the name '$request->name' already exists"]);
        }
        $product = [
            "name"=>$request->name,
            "description"=>$request->desc,
            "price_per_DT"=>$request->price_per_DT,
            "full_quantity"=>$request->full_quantity,
        ];
        if($request->file('image')){
            $new_name = $request->file('image')->HashName();
            Storage::disk("public")->put("img" , $request->file('image')  );
            $product['image'] = $new_name;
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
        $product = products::find($request->id);
        if($request->hasFile("image")){
            if($product->image && Storage::exists("img/".$product->image)){
                
                Storage::disk("public")->delete("img/".$product->image);
            }
            $file =$request->file('image');
            
            $new_name=$file->HashName();
            Storage::disk("public")->put("img" , $file ,'public' );
            $product->update(["image" => $new_name]);
        }
        $product->update(
            [
                "name"=>$request->name,
                "description"=>$request->desc,
                "full_quantity"=>$request->full_quantity,
            ]
            );
        return back()->with("msg","the updates are done with success");
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request)
    {
        $product = products::find($request->id);
        $name = $product->name;
        $orders = orders::where("product_name" , $name);
        
        if(!$orders->exists()){
            Storage::disk('public')->delete("img/".$product->image);
            $product->delete();
            return back()->with("msg","$product->name is delete from database with success");
            
        }
        return back()->withErrors(["existing orders"=>"you can't delete $name because there aresome remainig orders"]);
    }
}
