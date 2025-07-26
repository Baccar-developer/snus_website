@extends('layouts.layout')
@section('title')
About us
@endsection
@section('about_active')
active
@endsection
@section('content')
<br><br>
<div class="m-5 border border-white border-1 p-5 rounded-1">
	<div class="row">
	<div class="col-md-8 col-sm-6 ">
	<h1 class="text-danger">About us</h1>
		<p class="fs-5">{{fake()->text(1000) }}</p>
		<br>
		<h1 >what we give</h1>
		<div class="row pt-4 text_center">
			<div class="col-6">
				<h3>varity of snus marks <i class="fa-regular fa-circle-check"></i></h3>
			</div>
			<div class="col-6">
				<h3>delivery at your house <i class="fa-solid fa-truck"></i></h3>
			</div>
		</div>
	</div>
	<img class="col-md-4 col-sm-6" src="{{asset('assets/img/killa.webp')}}">
	</div>
	<button class="btn btn-danger fs-2 ps-3 pe-3">shop now</button>
	
	<br><br><br>
	<p class='fs-6 font-weight-light text-secondary align-content-center'><i class="fa-solid fa-copyright"></i> all rights are reserved</p>
	
</div>
@endsection