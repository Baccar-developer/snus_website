@extends('layouts.verification_layout')
@section('title')
email verification
@endsection

@section("content")
	<div class="container text-center form-container p-5">
		<h1 class="text-danger">Verify your email</h1>
		<br>
		<h3 class="text-light">we sent to you a verification code on email</h3>
		<br>
		<form method='get' class="text-center" action="{{url('/reset_password')}}">
    		<input type="hidden" name="code" value='{{$code}}'>
    		@if(isset($email))
    			<input type="hidden" name="email" value="{{$email}}">
    		@else
    			<input type="hidden" name="tel" value="{{$tel}}">
    		@endif
    		<input class="form-control" type='text'  name="verif" style="width:200px !important">
    		<br>
    		<button class="btn btn-danger fs-3" type="submit">verifie</button>
		</form>
		
	</div>

@endsection