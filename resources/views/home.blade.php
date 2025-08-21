@extends('layouts.layout')
@section('title')
Home
@endsection
@section('home_active')
active
@endsection

@section('content')

		
		
<div class='containe-fluid' style="background-color: rgb(4,14,0)" >
		<div class="row">
		<div class="col-6">
    			<img src="{{asset('assets/img/viking tunsi.jpeg')}}">
    		</div>
    			<div class="text-center pt-5 pe-5 col-6">
        		<h1>eshop for nicotine pipet</h1>
        		<h2>only destributer in Sousse</h2><h2> wellcome to this website</h2>
        		<a href="{{url('/shop')}}"><button class="btn btn-danger fs-4 rounded-5 m-4 p-3">buy from here!</button></a>
    			</div>
    		
    	
    	
    	
	</div>
</div>
<div class="container-fluid bg-danger p-2 row pb-5">
	<div class="col-md-4 col-sm-12 text-center">
		<h1>Killa</h1>
		<p class="fs-5">Killa nicotine pouches are produced by NGP Empire in Denmark. Killa has an average nicotine level, but with a heavy kick and is mainly aimed at smokers.</p>
		<img src='{{asset("assets/img/killa.png")}}' width='200px'>
	</div>
	<div class="col-md-4 col-sm-12 text-center p-2">
		<h1>Velo</h1>
		<p class="fs-5">Pablo Snus La marque Pablo Snus, une partie prominente du portefeuille de NGP Empire, occupe une place spéciale dans le monde</p>
		<img src='{{asset("assets/img/pablo_ice_cold.png")}}' width='200px'>
	</div>
	<div class="col-md-4 col-sm-12 text-center p-2">
		<h1>Pablo</h1>
		<p class="fs-5">VELO Snus est une marque suédoise réputée pour ses sachets de nicotine entièrement blancs et sa large gamme de saveurs.</p>
		<img src='{{asset("assets/img/velo.png")}}' width='200px'>
	</div>
	
</div>

<div class='container-fluid bg-dark text-center'>
	<a href='#location_section'><button id="scroll-button" class='btn-circle text-light'> <i class="fa-solid fa-angles-down fs-2"></i></button></a>
	<div class="row p-4" style='width:70% ; margin: 20px auto' id="location_section">
		<div class="col-md-9 col-sm-6">
		<p class='fs-5'>delivery to all Sousse locations</p>
    	<p>we will try to deliver snus orders to you where ever you are in Sousse.</p>
    	</div>
    	<img class="col-md-3 col-sm-6" src={{asset('assets/img/sousse.webp')}}>
    		
	</div>
	
</div>

@endsection