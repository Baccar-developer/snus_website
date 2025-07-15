<!DOCTYPE html5>
<html lang="en">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
	@vite('resources/css/app.css')
	@vite('resources/js/app.js')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<title>Admin login</title>
<body class='bg-dark text-light'>
<div class="m-5">
<form  method='post' action="{{url('AdminsController')}}">
	@csrf
	<label class='form-label text-danger fs-3'>name: </label><input name='name' type='text' 
	class='form-control bg-dark text-danger border-danger border-2 fs-3' value='{{old("name")}}'><br>
	<label class='form-label text-danger fs-3'>password: </label><input name='password' type='password'
	 class='form-control bg-dark text-danger border-danger border-2 fs-3'><br>
	<button  class='btn btn-danger fs-3' type='submit'>submit</button>
</form>
@foreach($errors->all() as $error)
<p class='text-white bg-secondary p-3'>{{$error}}</p>
@endforeach
</div>



</body>
</html>