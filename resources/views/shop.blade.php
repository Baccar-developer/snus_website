@extends("layouts.layout")
@section('title')shop
@endsection
@section('products_active')
active
@endsection
@section('content')
<div class=" produts_list g-3 container-fluid m-0 ">
<br>
@if($best)
	
    <div class='best card col-12 my-2 mx-auto'>
    <div class="row">
    	<div class="col-12 col-lg-6">
    	<img src="{{asset('storage/product_img/'.$best->product_image)}}" class="card-img-top" >
    	</div>
    	<div class='col-12 col-lg-6'>
    	<div class="card-body text-light">
			<h4>{{$best["product_name"]}}</h4>
			<p class="fs-5" style='max-height:200px'>{{$best->product_desc}}</p>
		    <ul>
				<li>price : {{$best["price_per_DT"]}}DT</li>
				@if($best->ratings !=0)
				<li>rating : 
					@include("includes.rate",["rate"=>$best->product_rate])
				</li>
				@endif
				@auth
				<li> <a class="btn btn-danger rounded-4 px-3 py-2 m-2" href="{{route('add_to_cart' ,$best->product_id)}}">Add to cart </a></li>
				@endauth
				<li> <a class="btn btn-danger rounded-4 px-3 py-2 m-2" href="{{route('product_reviews' , $best->product_id)}}">All reviews </a></li>
			</ul>
		  </div>
    	</div>
    </div>

		  
		</div>

@endif


    <div class="row m-auto justify-center g-3 for-fill product_list" >
    @if($data[0])
@foreach($data as $row)
<div class="col-12 col-lg-6 " >
	<div class="card">
		  <img src="{{asset('storage/product_img/'.$row['product_image'])}}" class="card-img-top" alt="...">
		  <div class="card-body text-light">
			<h4>{{$row["product_name"]}}</h4>
			<p  style="height:150px">{{$row->product_desc}}</p>
		    <ul>
				<li>price : {{$row["price_per_DT"]}}DT</li>
				@if($row->ratings !=0)
				<li>rating : 
				@include('includes.rate' ,['rate'=>$row["product_rate"]])
				</li>
				@endif
				@auth
				<li> <a class="btn btn-danger rounded-4 px-3 py-2 m-2" href="{{route('add_to_cart' ,$row->product_id)}}">Add to cart </a></li>
				@endauth
				<li> <a class="btn btn-danger rounded-4 px-3 py-2 m-2" href="{{route('product_reviews' , $row->product_id)}}">All reviews </a></li>
			</ul>
		  </div>
		</div>
	</div>
	@endforeach
    </div>
	
{{$data->links()}}
@else
<h2 class="text-secondary text-center">there is no products</h2>
@endif
</div>


@endsection
