@extends("layouts.layout")
@section('title')
your reviews
@endsection
@section('content')
<div class="container p-5 for-fill" id="scrollable">
<h1 class="text-danger"> your previous reviews <i class="fa-solid fa-comment"></i></h1>
<br>	<br>
	@if(!isset($reviews[0]))
	
		<h3 class="text-secondary">you didn't review at any thing yet</h3>
		
	@else
		@foreach($reviews as $r)
			<div style="background-color: var(--bs-gray-800); " class="mb-5 p-4">
			<div class="row">
				<div class="col-6"><img src="{{asset('storage/product_img/'.$r->product_image)}}" height=200px width=200px ></div>
				<div class="col-6 ">
					<h2>{{$r->product_name}}</h2>
					<h3>rate: @include('includes.rate' ,['rate'=>$r->product_rate])</h3>
					<a class="btn btn-danger rounded-4 px-3 py-2 m-2" href="{{route('add_to_cart' ,$r->product_id)}}">Add to cart </a>
					 <a class="btn btn-danger rounded-4 px-3 py-2 m-2" href="{{route('product_reviews' , $r->product_id)}}">All reviews </a>
				</div>
				<div class="container-fluid d-flex mt-4 align-items-center">
					@include('includes.avatar',["radius"=>'50px' , 'avatar'=>Auth::user()->avatar]) 
					<h5 class="m-1">{{Auth::user()->customer_name}}</h5>
					<h5 class="m-1">@include('includes.rate' , ["rate" =>$r->rate])</h5>
					<h5 class="ms-auto text-secondary">{{$r->created_at}}</h5>
				</div>
				<div class="container-fluid bg-dark p-4 fs-5 rounded-3">{{$r->comment}}</div>
				
			</div>
			</div>
		@endforeach
		
		
		<script>
var step = 4;
var offset =4;
var loading = false;
var end =false

$(window).on("scroll.once", function() {
	if(end==true){return;}
    if ($(window).scrollTop() >= $(document).height()-$("#scrollable").height()+$("#scrollable").position().top ){
        if(loading === false){
            loading = true;
            $.ajax({
                url: '{{url("profile/reviews/scroll")}}',
                method:'POST',
                cache:true,
                data:{start:offset , step:step , _token: '{{ csrf_token() }}'},
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
	@endif
	
</div>

@endsection