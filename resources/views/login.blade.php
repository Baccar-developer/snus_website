@extends('layouts.layout')
@section('title')
login
@endsection
@section("login_active")
active
@endsection
@section('content')
<div class="for-fill py-5">
<br>
<br>
<br>
	<div class="form-container m-auto p-5 rounded-3 text-center" >
		<h1 class="text-danger">LogIn</h1>
		<br>
		<form class="px-5" method='post' action="{{route('login_user')}}">
		@csrf
		<label class="text-danger control-label me-auto">email or tel</label>
			<input type='text' placeholder="enter your email or tel°N" class="form-control py-2 mb-3" name="email_or_tel" value="{{old('email_or_tel')}}">
		<label class="text-danger control-label me-auto">password</label>
			<input type='password' placeholder="enter your password" class="form-control py-2 mb-3" name="password" value="{{old('password')}}">
			<div class="d-flex">
        		<a class="fs-6 text-danger">forgot password?</a> 
        		<p class="text-danger ms-auto"><input type="checkbox" class="form-check-input" name="remember"> remeber me</p></div>
    		<br>
    		<button type="submit" class="btn btn-danger fs-3 rounded-5 px-4">Login</button>
    		</form>
    		<a class="fs-6 text-danger" href='{{url("/signup")}}'>don't have account?</a> 
    	</div>
	</div>
@endsection