<!DOCTYPE html5>
<html lang="en">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
	@vite('resources/css/app.css')
	@vite('resources/js/app.js')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<title>@yield('title')</title>
<body class='bg-dark text-light'>

<div class="conteiner-fluid p-4 text-center">
	<p class="fs-4"> current_Admin : {{$name}}</p>
	<a href='{{route("dashboard")}}'><button type="button" class='btn btn-danger'> Products</button></a>
	<a href='{{url("orders_dashboard")}}'><button  type="button" class='btn btn-danger'> Orders</button></a>
	<button type="button" class='btn btn-danger'> log out</button>
</div>
@yield('custom')
<table class='table table-dark table-striped table-fluid' >
@yield('content')
</table>



</body>
</html>