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
<nav class="navbar navbar-expand-lg bg-danger ">
	  <div class="container-fluid ">
	    <a class="navbar-brand fs-3 text-light fw-bold" href="#">Title_here</a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarNav">
	      <ul class="navbar-nav >
	        <li class="nav-item">
	          <a class="nav-link fs-4 @yield('home_active')"  href="{{url('/')}}">Home</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link  fs-4 fs-4 @yield('products_active')" href="{{url('/shop')}}" >products</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link fs-4 @yield('about_active')" href="{{url('/AboutUs')}}">about_us</a>
	        </li>
	        <li class="nav-item">
	        </li>
	      </ul>
	    </div>
	  </div>
	</nav>

@yield('content')
<footer class="bg-danger p-5" >
	<ul>
		<li>:**********phone number:</li>
		<li><p>our social media pages</p>
			<p><i class="fa-brands fa-facebook"></i></p></li>
	</ul>
	<p>delivery to Sousse only</p>
</footer>
</body>
</html>