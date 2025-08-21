<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width-device-width initial-scale-1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	@vite('resources/css/app.css')
	@vite('resources/js/app.js')
	
	<link rel="icon" href="{{asset('favicon.svg')}}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<title>@yield('title')</title>
</head>
<body class='bg-dark text-light'>

@if(session()->has('msg'))

<p class="alert alert-success fs-5">{{session()->get('msg')}}</p>

@endif
@if($errors->any())
<ul class="alert alert-danger fs-5 p-3">
@foreach($errors->all() as $err)
<li >{{$err}}</li>
@endforeach
</ul>
@endif

<div class="conteiner-fluid p-4 text-center">
	<p class="fs-4"> current_Admin : {{Auth::guard('admin')->user()->name}}</p>
	<a href='{{route("dashboard")}}'><button type="button" class='btn btn-danger'> Main</button></a>
	<a href='{{route("products_dashboard")}}'><button type="button" class='btn btn-danger'> Products</button></a>
	<a href='{{route("orders_dashboard")}}'><button  type="button" class='btn btn-danger'> Orders</button></a>
	<a href='{{route("disconnect_admin")}}'><button type="button" class='btn btn-danger'> log out</button></a>
</div>
@yield('custom')
<div id="filter">
<table class='table table-dark table-striped table-fluid fs-5' >
@yield('content')
</table>
<div class="container-fluid p-3">
@yield('pagination')
</div>
</div>
</body>
</html>