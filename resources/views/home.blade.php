@extends('layouts.layout')
@section('title')
Home
@endsection
@section('home_active')
active
@endsection

@section('content')

		
		
<div class='containe-fluid p-5 for-fill bg-image'>
	<div class="row">
    	<div class="col-4 ps-5 pt-5">
    		<h1>eshop for nicotine pipet</h1>
    		<h2>only destributer in Sousse</h2><h2> write something here</h2>
    		<a href="{{url('/shop')}}"><button class="btn btn-danger fs-4 rounded-5 m-4 p-3">buy from here!</button></a>
    	</div>
    	<div class="col-8 text-center">
    		<h2>put a better image</h2>
    	</div>
	</div>
</div>
<div class="container-fluid bg-danger p-2 row pb-5">
	<div class="col-md-4 col-sm-12 text-center">
		<h1>spam1</h1>
		<p class="fs-5">{{fake()->text()}}</p>
		<img src='{{asset("assets/img/img.png")}}' width='200px'>
	</div>
	<div class="col-md-4 col-sm-12 text-center p-2">
		<h1>spam2</h1>
		<p class="fs-5">{{fake()->text()}}</p>
		<img src='{{asset("assets/img/img.png")}}' width='200px'>
	</div>
	<div class="col-md-4 col-sm-12 text-center p-2">
		<h1>spam3</h1>
		<p class="fs-5">{{fake()->text()}}</p>
		<img src='{{asset("assets/img/img.png")}}' width='200px'>
	</div>
	
</div>

<div class='container-fluid bg-dark text-center'>
	<a href='#location_section'><button id="scroll-button" class='btn-circle text-light'> <i class="fa-solid fa-angles-down fs-2"></i></button></a>
	<div class="row p-4" style='width:70% ; margin: 20px auto' id="location_section">
		<div class="col-md-9 col-sm-6">
		<p class='fs-5'>delivery to all Sousse locations</p>
    	<p>{{fake()->text}}</p>
    	</div>
    	<img class="col-md-3 col-sm-6" src={{asset('assets/img/sousse.webp')}}>
    		
	</div>
	
</div>

@endsection