<?php

namespace App\Http\Controllers;

use App\Models\admins;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
    public function show(admins $admins)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(admins $admins)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, admins $admins)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(admins $admins)
    {
        //
    }
}
