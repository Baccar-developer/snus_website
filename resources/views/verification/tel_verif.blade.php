@extends('layouts.verification_layout')
@section('title')
tel verification
@endsection

@section("content")
	<div class="container text-center form-container p-5">
		<h1 class="text-danger">Verify you phone number</h1>
		<br>
		<h3 class="text-light">we sent to you a verification code on sms</h3>
		<br>
		<form method='post' action="{{route('add_user')}}">
    		@csrf
    		<input type="hidden" name="tel" value='{{$tel}}'>
    		<input type="hidden" name="password" value='{{$password}}'>
    		<input type="hidden" name="name" value='{{$name}}'>
    		<input type="hidden" name="code" value='{{$code}}'>
    		<div class="d-flex justify-content-center">
        		<input type="text" name="digit_1" maxlength=1 class="single_digit_input">
        		<input type="text" name="digit_2" maxlength=1  class="single_digit_input">
        		<input type="text" name="digit_3" maxlength=1  class="single_digit_input">
        		<input type="text" name="digit_4" maxlength=1  class="single_digit_input">
        		<input type="text" name="digit_5" maxlength=1  class="single_digit_input">
        		<input type="text" name="digit_6" maxlength=1  class="single_digit_input">
    		</div>
    		<br>
    		<button class="btn btn-danger fs-3" type="submit">verifie</button>
		</form>
		
	</div>

@endsection