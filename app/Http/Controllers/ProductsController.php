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
        $data = products::all();
        return view('dashboard_products' )->with(['name'=> Auth::guard('admin')->user()->name , "data"=>$data]);
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
    public function update(Request $request)
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
        $orders = orders::where("product_name" , $name)->get();
        if(is_null($orders)){
            Storage::disk('public')->delete("img/".$product->value('image'));
            $product->delete();
            return back()->with("msg","$product->name is delete from database with success");
            
        }
        return back()->withErrors(["existing orders"=>"you can't delete $name because there aresome remainig orders"]);
    }
}
