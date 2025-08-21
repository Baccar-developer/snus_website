@foreach($reviews as $r)
			<div style="background-color: var(--bs-gray-800); " class="mb-5 p-4">
			<div class="row">
				<div class="col-6"><img src="{{asset('storage/product_img/'.$r->product_image)}}" height=200px width=200px ></div>
				<div class="col-6 ">
					<h2>{{$r->product_name}}</h2>
					<h5 style="height:100px">{{$r->product_desc}}</h5>
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