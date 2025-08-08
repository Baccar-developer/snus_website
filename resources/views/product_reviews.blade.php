@extends('layouts.layout')
@section('title')
{{$product->product_name}} reviews
@endsection
@section('content')
<br>
<?php 
    use App\Models\reviews;
    use Illuminate\Support\Facades\Auth;

?>
<div class="container " id='scrollable'>
    <div style="background-color: var(--bs-gray-800); " class="mb-5 p-4" >
    	<div class="row">
    		<div class="col-6"><img src="{{asset('storage/product_img/'.$product->product_image)}}" height=200px width=200px ></div>
    		<div class="col-6 ">
    			<h2>{{$product->product_name}}</h2>
    			<h4> {{$product->product_desc}}</h4>
    			<h3>rate: @include('includes.rate' ,['rate'=>$product->product_rate])</h3>
    			<a class="btn btn-danger rounded-4 px-3 py-2 m-2" href="{{route('add_to_cart' ,$product->product_id)}}">Add to cart </a>
    		</div>
    	</div>
    </div>
    
	<!-- ratin form for user-->
	@auth
	<?php
	  
	   $user_review = reviews::where("product_id" , $product->product_id)->where("customer_id" , Auth::id())->first()
	?>
	@if(!isset($user_review))
	<div class="container px-5 py-2" style="background-color:var(--bs-gray-800)">
		<div class="d-flex align-items-center">@include('includes.avatar' ,['avatar'=>Auth::user()->avatar, 'radius'=>'50px'])<h3>{{Auth::user()->customer_name}}</h3></div>
		<ul class="star_bar" target="#rate" display="#msg">
			<li><i class="fa-regular fa-star" id="star-1"></i></li>
			<li><i class="fa-regular fa-star" id="star-2"></i></li>
			<li><i class="fa-regular fa-star" id="star-3"></i></li>
			<li><i class="fa-regular fa-star" id="star-4"></i></li>
			<li><i class="fa-regular fa-star" id="star-5"></i></li>
		</ul>
		<h4 id="msg"></h4>
		<form method='post' action='{{route("rate_product")}}'>
			<input type="hidden" name="rate" value=1 id="rate">
			<input type="hidden" name="product_id" value='{{$product->product_id}}'>
			@csrf
			<textarea name="comment" placeholder='enter your comment' class="form-control "></textarea>
			<button class="btn btn-danger" type="submit">enter</button>
		</form>
		<script>
			var stars =$(".star_bar").children();
			var msg=["","abondonne it🥱" , "not good 👎" , "ok😐","that's actually good👍" , "awesome!🤩"]
			stars.each(function(){
				$(this).hover(function(){
					i=1;
					for(i=1;i< stars.index(this)+2;i++){
						$('#star-'+i).attr("class" ,"fa-solid fa-star");
					}
					$($(this).parent().attr("display")).text(msg[i-1]);
					for(i=stars.index(this)+2;i<6;i++){
						$('#star-'+i).attr( "class","fa-regular fa-star")
						
					}
				});
				
				$(this).mouseleave(function(){
					num =$($(this).parent().attr("target")).val();
					var i=0;
					for(i=0;i<num;i++){
						$('#star-'+i).attr("class" ,"fa-solid fa-star");
					}
					$($(this).parent().attr("display")).text(msg[Number(num)]);
					for(i=Number(num)+1 ;i<6;i++){
						$('#star-'+i).attr( "class","fa-regular fa-star")
						
					}
				});
				$(this).click(function(){
					$($(this).parent().attr('target')).val(stars.index(this)+1);
				});
			});
		</script>
	</div>
	@endif
	
	@endauth

	
    @foreach($reviews as $r)
    <div class="container p-5 my-4" style='background-color:var(--bs-gray-800)'>
    	<div class="container d-flex mb-2 align-items-center ">
			@include('includes.avatar',["radius"=>'50px' , 'avatar'=>$r->avatar]) 
			<h5 class="m-1">{{$r->customer_name}}</h5>
			<h5 class="m-1">@include('includes.rate' , ["rate" =>$r->rate])</h5>
			<h5 class="ms-auto text-secondary">{{$r->created_at}}</h5>
		</div>
		<div class="container-fluid bg-dark p-4 fs-5 rounded-3">{{$r->comment}}</div>
				
	</div>
    @endforeach



		<script>
var step = 2;
var offset =4;
var loading = false;
var end =false

$(window).on("scroll.once", function() {
	if(end==true){return;}
    if ($(window).scrollTop() >= $(document).height()-$("#scrollable").height()+$("#scrollable").position().top ){
        if(loading === false){
            loading = true;
            $.ajax({
                url: '{{url("/reviews/scroll",$product->product_id)}}',
                method:'get',
                cache:true,
                data:{ start:offset , step:step },
                success: function (data) { 
                if (data!=''){
                	offset+=step; $('#scrollable').append(data); loading = false; 
                	}
                else{
                	$('#scrollable').append("<h4 class='text-secondary'>there is no more reviews</h4>");
                	console.log("added");
                	end = true
                }},
                dataType: 'html'
            });
        }
    }
});
</script>
</div>
@endsection