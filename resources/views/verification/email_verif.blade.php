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
		<form method='patch' action="{{route('change_email')}}">
    		@csrf
    		<input type="hidden" name="code" value='{{$code}}'>
    		<input class="form-control" type='text' max-length=6 name="verif">
    		<br>
    		<button class="btn btn-danger fs-3" type="submit">verifie</button>
		</form>
		
	</div>

@endsection