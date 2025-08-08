<!DOCTYPE html5>

<html lang="en">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
	@vite('resources/css/app.css')
	@vite('resources/js/app.js')
	<script
			  src="https://code.jquery.com/jquery-3.7.1.js"
			  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
			  crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<title>@yield('title')</title>
</head>
<body class='bg-dark text-light'>
<nav class="navbar navbar-expand-lg bg-danger ">
	  <div class="container-fluid ">
	    <a class="navbar-brand fs-3 text-light"  href="{{url('/')}}">LOGO</a>
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
	          <a class="nav-link fs-4 @yield('about_active')" href="{{url('/about_us')}}">about_us</a>
	        </li><li class="nav-item">
	          <a class="nav-link fs-4 @yield('login_active')" href="{{url('/login')}}">login</a>
	        </li>
	        <li class="nav-item">
	        </li>
	      </ul>
	    </div>
	  </div>
	</nav>
	@auth
	<script >
	$( document ).ready(function(){
		$('#side_toggler').click(function(){
			if( $('.sidebar').attr('toggled' )=='true'){
				$('.sidebar').attr('toggled', 'false');
				$('.nav-item span').animate({width:'0' , 'margin-right': 0} ,400);
				$(this)
			}
			else{
				$('.sidebar').attr('toggled', 'true');
				$('.nav-item span').animate({width:'150px' , 'margin-right':'40px'} ,400);
			}
		})
	});
	</script>
	<aside class="sidebar"  toggled='true'>
	<ul class="sidebar-btn">
	
		<li  class="nav-item"><button class="nav-link" id="side_toggler"> <span></span><i class="fa-solid fa-angles-left"></i></button></li>
		<li  class="nav-item"> <a class="nav-link" href='{{route("profile")}}'><span>PROFILE</span><i class="fa-solid fa-user"></i></a></li>
		<li  class="nav-item"> <a class="nav-link" href="{{route('user_orders')}}"><span>ORDERS</span><i class="fa-solid fa-bag-shopping"></i></a></li>
		<li  class="nav-item"><a class="nav-link" href="{{route('current_cart')}}"><span>YOUR CART</span><i class="fa-solid fa-cart-shopping"></i></a></li>
		<li  class="nav-item"><a class="nav-link" href="{{route('user_reviews')}}"><span>YOUR REVIEWS</span><i class="fa-solid fa-comment"></i></a></li>
		<li  class="nav-item"><a class="nav-link" href="{{url('/shop')}}"><span>SHOP</span><i class="fa-solid fa-shop"></i></a></li>
		<li  class="nav-item"><a class="nav-link"  href='{{url("/logout")}}'><span>LOG OUT</span><i class="fa-solid fa-arrow-right-from-bracket"></i></a></li>
	</ul>
	</aside>
	@endauth
    <div class='container-fluid p-0 m-0'>
    @if(session()->has('msg'))
    
    <p class="alert alert-success fs-5">{{session()->get('msg')}}</p>
    
    @endif
    @if($errors->any())
    <ul class="alert alert-danger fs-5">
        @foreach($errors->all() as $err)
        <li >{{$err}}</li>
        @endforeach
    </ul>
    @endif
   </div>
@yield('content')
<footer class="bg-danger p-5 " >
	<ul>
		<li>:**********phone number:</li>
		<li><p>our social media pages</p>
			<p><i class="fa-brands fa-facebook"></i></p></li>
		<li>creator and first editor of this website: 'mohammed amine baccar'</li>
	</ul>
	<p class="ps-3">delivery to Sousse only</p>
	
</footer>
</body>
</html>