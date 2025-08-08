@extends("layouts.layout")
@section('title')shop
@endsection
@section('products_active')
active
@endsection
@section('content')

<div class=" produts_list g-3 container-fluid m-5">
    <div class='card col-12 my-2 mx-auto' style='width:50vw'>
    <div class="row">
    	<div class="col-6">
    	<img src="{{asset('storage/product_img/'.$best->product_image)}}" class="card-img-top">
    	</div>
    	<div class='col-6'>
    	<div class="card-body text-light">
			<h4>{{$best["product_name"]}}</h4>
			<h5>{{$best->product_desc}}</h5>
		    <ul>
				<li>price : {{$best["price_per_DT"]}}DT</li>
				<li>rating : 
					@include("includes.rate",["rate"=>$best->product_rate])
				</li>
				<li> <a class="btn btn-danger rounded-4 px-3 py-2 m-2" href="{{route('add_to_cart' ,$best->product_id)}}">Add to cart </a></li>
				<li> <a class="btn btn-danger rounded-4 px-3 py-2 m-2" href="{{route('product_reviews' , $best->product_id)}}">All reviews </a></li>
			</ul>
		  </div>
    	</div>
    </div>

		  
		</div>



    <div class="row m-auto justify-center g-3" style='width:50vw'>
@foreach($data as $row)
<div class="col-md-6 col-sm-12 " >
	<div class="card">
		  <img src="{{asset('storage/product_img/'.$row['product_image'])}}" class="card-img-top" alt="...">
		  <div class="card-body text-light">
			<h4>{{$row["product_name"]}}</h4>
			<h5>{{$row->product_desc}}</h5>
		    <ul>
				<li>price : {{$row["price_per_DT"]}}DT</li>
				<li>rating : 
				@include('includes.rate' ,['rate'=>$row["product_rate"]])
				</li>
				<li> <a class="btn btn-danger rounded-4 px-3 py-2 m-2" href="{{route('add_to_cart' ,$row->product_id)}}">Add to cart </a></li>
				<li> <a class="btn btn-danger rounded-4 px-3 py-2 m-2" href="{{route('product_reviews' , $row->product_id)}}">All reviews </a></li>
			</ul>
		  </div>
		</div>
	</div>
	@endforeach
    </div>

</div>
{{$data->links()}}


@endsection