@extends('layouts.verification_layout')
@section('title')
email
@endsection

@section("content")
	<div class="container text-center form-container p-5">
		<h1 class="text-danger">enter email</h1>
		<h3 class='text-light'>enter your email so we can send you a verification code</h3>
		<br>
		<form method='post' action="{{route('verif_email')}}">
    		@csrf
    		<input name="email" type="email" class="form-control" >
    		<br>
    		<button class="btn btn-danger fs-3" type="submit">send</button>
		</form>
		
	</div>

@endsection