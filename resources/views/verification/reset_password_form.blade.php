@extends("layouts.verification_layout")
@section('title')
reset password
@endsection
@section('content')
			<script
			  src="https://code.jquery.com/jquery-3.7.1.js"
			  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
			  crossorigin="anonymous"></script>
            	
	<div class="container text-center form-container p-5 align-items-center">
	<h1 class="text-danger">Reset Your Password</h1>
	<form method='post' class="text-center text-light" action="{{url('/reset_password/reset')}}">
	
		@csrf
		@method("put")
		@if($email)
			<input type="hidden" name="email" value={{$email}}>
		@else
			<input type="hidden" name="tel" value={{$tel}}>
		@endif
		<label class="form-label">new password:</label>
		<div class="d-flex align-items-center"><input class="form-control" name="password" type="password" placeholder="enter your new password">
			<i class="fa-regular fa-eye"></i>
			</div>
		<label class="form-label">confirm password:</label>
		<div class="d-flex align-items-center">
		<input class="form-control" name="confirm-password" type="password" placeholder="confirm your password">
		<i class="fa-regular fa-eye"></i>
		</div>
		<button class="btn btn-danger" type="submit">reset</button>
	</form>
	<script>
		$('i').mousedown(function(){
			$(this).parent().children("input").attr("type" ,"text");
		});
		$('i').mouseup(function(){
			$(this).parent().children("input").attr("type" ,"password");
		});
	</script>
	</div>
@endsection