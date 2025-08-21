@extends('layouts.layout')
@section('title')
About us
@endsection
@section('about_active')
active
@endsection
@section('content')
<br><br>
<div class="border border-white border-1  rounded-1" style="margin: 20px 20px 20px 100px ; padding :20px">
	<div class="row">
	<div class="col-12 col-xl-8 ">
	<h1 class="text-danger">About us</h1>
		<p class="fs-5">
			SemSem Store is an eshop of snus, we sell variety of snus marks for the different tastes,
			our job is to take your orders and deliver it to your door.
			we are the only distributor of snus in Sousse and our service doesn't reach to somewehere
			further for now.
		</p>
		<p class="fs-5">
			we created this website to make orders handling easier, and to enable you to discover
			and buy products using an easy and facinating platforme.
		</p>
		<p>thanks for chousing SemSem Store to deal with ❤️</p>
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
	<img class="col-12 col-xl-4 p-5" src="{{asset('assets/img/yzYpQ')}}eV8.jpeg">
	</div>
	<a href="{{url('/shop')}}"><button class="btn btn-danger fs-2 ps-3 pe-3">shop now</button></a>
	
	<br><br><br>
	<p class='fs-6 font-weight-light text-secondary align-content-center'><i class="fa-solid fa-copyright"></i> all rights are reserved</p>
	
</div>
@endsection