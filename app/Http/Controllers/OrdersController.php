<?php

namespace App\Http\Controllers;

use App\Models\orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = orders::all();
        return view('admin_pages.dashboard_orders' )->with(['name'=> Auth::guard('admin')->user()->name , "data"=>$data]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
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
    public function update(Request $request, orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function check($id){
        $order = orders::find($id);
        $order->update(["state"=>"delivered" , "payed"=>true]);
        return back()->with("msg" , "order is checked");
    }
    
    public function destroy(Request $request)
    {
        orders::destroy($request->id);
        return back()->with("msg" , "deletion done with sucess");
        
    }
}
