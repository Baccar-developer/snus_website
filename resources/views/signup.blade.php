@extends('layouts.layout')
@section('title')
signup
@endsection

@section('content')
<div class="for-fill items-center">
<br>
<br>
<br>
	<div class="form-container m-auto p-5 rounded-3 text-center" >
		<h1 class="text-danger">Signup</h1>
		<br>
		<form class="px-5" action='{{route("verif_tel")}}' method='post'>
		@csrf
			<label class="text-danger form-label">your name</label>
			<input type="text" name="name" class='form-control mb-3' placeholder="enter your name" value="{{old('name')}}">
		<label class="text-danger control-label me-auto">tel°N</label>
			<input type='tel' placeholder="+216" class="form-control py-2 mb-3" name="tel" value="{{old('tel')}}">
			
		<label class="text-danger form-label me-auto">password</label>
		<div class="d-flex align-items-center">
			<input type='password' placeholder="enter your password" class="form-control py-2 mb-3" name="password" value="{{old('password')}}">
			<i class="fa-regular fa-eye"></i>
		</div>
		<label class="text-danger form-label me-auto">confirm password</label>
		<div class="d-flex align-items-center">
			<input type='password' placeholder="confirm your password" class="form-control py-2 mb-3" name="password-confirme" value="{{old('password-confirme')}}">
			<i class="fa-regular fa-eye"></i>
		</div>
    		<br>
    		<button type="submit" class="btn btn-danger fs-3 rounded-5 px-4">Sign in</button>
    		</form>
    		<a class="fs-6 text-danger" href="{{url('/login')}}">already have account?</a> 
    	</div>
	</div>
	<script>
		$('i').mousedown(function(){
			$(this).parent().children("input").attr("type" ,"text");
		});
		$('i').mouseup(function(){
			$(this).parent().children("input").attr("type" ,"password");
		});
	</script>
@endsection