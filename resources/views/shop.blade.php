@extends("layouts.layout")
@section('title')
shop
@endsection
@section('products_active')
active
@endsection
@section('content')

<div class="container-fluid produts_list ">
@foreach($data as $row)
<div class="card col-md-6 col-sm-12" style="width: 18rem; background: rgb(32,32,32); margin:50px">
		  <img src="{{asset('storage/img/'.$row['image'])}}" class="card-img-top" alt="...">
		  <div class="card-body text-light">
			<h4>{{$row["name"]}}</h4>
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
					echo '<i class="far fa-star-half-stroke"></i>';
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
	@endforeach
</div>
{{$data->links()}}
@endsection