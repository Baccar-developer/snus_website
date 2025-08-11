@extends('layouts.verification_layout')
@section('title')
restore account
@endsection
@section('content')

<div class="container text-center form-container p-5">
		<h1 class="text-danger">Verify your email</h1>
		<br>
		<h3 class="text-light">we sent to you a verification code on email</h3>
		<br>
		<form method='post' action="{{route('account_validation')}}">
    		@csrf
    		<label class="form-label text-danger">tel or email</label>
    		<input class="form-control" type='text' name="tel_or_email">
    		<br>
    		<button class="btn btn-danger fs-3" type="submit">send</button>
		</form>
		
	</div>

@endsection