@extends('layouts.layout')
@section('title')
login
@endsection

@section('content')
<div class="for-fill py-5">
<br>
<br>
<br>
	<div class="form-container m-auto p-5 rounded-3 text-center" >
		<h1 class="text-danger">Signin</h1>
		<br>
		<form class="px-5">
		<label class="text-danger control-label me-auto">tel°N</label>
			<input type='tel' placeholder=" tel°N" class="form-control py-2 mb-3" name="tel">
			
		<label class="text-danger control-label me-auto">password</label>
			<input type='password' placeholder="enter your password" class="form-control py-2 mb-3" name="password">
			
		<label class="text-danger control-label me-auto">confirm password</label>
			<input type='password' placeholder="confirm your password" class="form-control py-2 mb-3" name="password-confirme">
			
    		<br>
    		<button type="submit" class="btn btn-danger fs-3 rounded-5 px-4">Sign in</button>
    		</form>
    		<a class="fs-6 text-danger" href="{{url('/Login')}}">alredy have account?</a> 
    	</div>
	</div>
@endsection