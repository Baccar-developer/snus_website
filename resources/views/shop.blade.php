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
    	<img src="{{asset('storage/product_img/'.$best['product_image'])}}" class="card-img-top">
    	</div>
    	<div class='col-6'>
    	<div class="card-body text-light">
			<h4>{{$best["product_name"]}}</h4>
		    <ul>
				<li>price : {{$best["price_per_DT"]}}DT</li>
				<li>rating : 
					<?php 
					$num = floor($best['rate']);
				for($i= 0; $i< $num; $i++){
					echo '<i class="fas fa-star" style="color: #FFD43B;"></i>';
				}
				$decimal = $best["rate"] - $num;
				if ($decimal < 0.33){
					echo '<i class="far fa-star" style="color: #FFD43B;"></i>';
				}
				else if ($decimal < 0.67){
					echo '<i class="far fa-star-half-stroke" style="color: #FFD43B;"></i>';
				}
				else{
					echo '<i class="fas fa-star" style="color: #FFD43B;"></i>';
				}
				for ($i= $num; $i< 4 ; $i++){
					echo '<i class="far fa-star" style="color: #FFD43B;"></i>';
					
				}
			?>
				</li>
				<li> <a class="btn btn-danger rounded-5 p-1" href="purchase_page.html">purchase</a></li>
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
		    <ul>
				<li>price : {{$row["price_per_DT"]}}DT</li>
				<li>rating : 
					<?php 
				$num = floor($row['rate']);
				for($i= 0; $i< $num; $i++){
					echo '<i class="fas fa-star" style="color: #FFD43B;"></i>';
				}
				$decimal = $row["rate"] - $num;
				if ($decimal < 0.33){
					echo '<i class="far fa-star" style="color: #FFD43B;"></i>';
				}
				else if ($decimal < 0.67){
					echo '<i class="far fa-star-half-stroke" style="color: #FFD43B;"></i>';
				}
				else{
					echo '<i class="fas fa-star" style="color: #FFD43B;"></i>';
				}
				for ($i= $num; $i< 4 ; $i++){
					echo '<i class="far fa-star" style="color: #FFD43B;"></i>';
					
				}
			?>
				</li>
				<li> <a class="btn btn-danger rounded-5 p-1" href="purchase_page.html">purchase</a></li>
			</ul>
		  </div>
		</div>
	</div>
	@endforeach
    </div>

</div>
{{$data->links()}}
@endsection