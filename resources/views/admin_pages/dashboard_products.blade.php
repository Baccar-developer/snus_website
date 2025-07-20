@extends('layouts.admin_layout')

@section('title')
Dashboard
@endsection
@section("custom")

<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">confirm deletion</h5>
      </div>
      <div class="modal-body">
        <p>do you realy want to delete this product?</p>
      </div>
      <div class="modal-footer">
      <form method='post' action ="{{route('delete_product')}}" >
      @csrf
      @method("delete")
      <input type="number" name="id" style="display:none" id='id' step=1>
        <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		$(".confirm").click(function(){
			$(".modal").show();
			$("form #id").attr( 'value',Number($(this).parent().attr("id")))  ;
			
		});
		$(".modal-footer .btn-secondary").click(function(){
			$(".modal").hide();
		});
		
		
	});
</script>
<div class="container-fluid m-3 text-center">
<a href="{{route('product_add_page')}}"><button class='btn btn-danger'>add new product</button></a>
</div>

<!-- ------------------filter form ------------------------- -->
<!--  
<div class="filter-section">
	<button class="btn" style='float:right' id ="collapse-btn"><i class="fa-solid fa-minus fs-3"></i></button>
	
	<br style="line-height:3">
	<div id="collapsed" toggled=true>
	<h1 width=100%>filter <i class="fa-solid fa-filter"></i></h1>
		<div class="d-flex align-items-center" ><label class="form-label">name:</label><input type="text" name="name"  class="form-control"></div>
		<div class="d-flex align-items-center">
		<label class="form-label">price per DT:</label>
		<input type="number" step=0.01  min=0 max=999 value=999 name="max_price" class="form-control" ><label class="form-label">max</label>
		<input type="number" step=0.01 min=0 max=999  value=0 name="min_price" class="form-control" ><label class="form-label">min</label>
		</div>
		<div class="d-flex align-items-center">
		<label class="form-label">full quantity:</label>
		<input type="number"  min=0 max=999  value=999 name="max_qnt" class="form-control" ><label class="form-label">max</label>
		<input type="number" min=0 max=999  value=0 step=0.01 name="min_qnt" class="form-control" ><label class="form-label">min</label>
		</div>
		<div class="d-flex align-items-center">
		<label class="form-label">ordered quantity:</label>
		<input type="number"  min=0 max=999  value=999 name="max_ordered" class="form-control" ><label class="form-label">max</label>
		<input type="number" min=0 max=999  value=0 step=0.01 name="min_ordered" class="form-control" ><label class="form-label">min</label>
		</div>
		<div class="d-flex align-items-center">
		<label class="form-label">sold quantity:</label>
		<input type="number"  min=0 max=9999  value=9999 name="max_sold" class="form-control" ><label class="form-label">max</label>
		<input type="number" min=0 max=9999  value=0 step=0.01 name="min_sold" class="form-control" ><label class="form-label">min</label>
		</div>
		<div class="d-flex align-items-center">
		<label class="form-label">gains per DT:</label>
		<input type="number"  min=0 max=9999  value=9999 name="max_gain" class="form-control" ><label class="form-label">max</label>
		<input type="number" min=0 max=9999  value=0 step=0.01 name="min_gain" class="form-control" ><label class="form-label">min</label>
		</div>
		<div class="d-flex align-items-center">
		<label class="form-label">rate:</label>
		<input type="number"  step=0.001 min=0 max=5  value=5 name="max_rate" class="form-control" ><label class="form-label">max</label>
		<input type="number" step=0.001 min=0 max=5  value=0 step=0.01 name="min_rate" class="form-control" ><label class="form-label">min</label>
		</div>
		<div class="d-flex align-items-center">
		<label class="form-label">added since:</label>
		<input type="radio"  value=1 name="add_date" class="form-check-input" ><label class="form-label">last 24h</label>
		<input type="radio"  value=2 name="add_date" class="form-check-input" ><label class="form-label">last week</label>
		<input type="radio"  value=3 name="add_date" class="form-check-input" ><label class="form-label">last month</label>
		<input type="radio"  value=4 name="add_date" class="form-check-input" ><label class="form-label">last year</label>
		
		</div>
		<button class="btn btn-dark fs-2" id="filter-button">filter</button>
	</div>
</div>

<script>
	$(document).ready(function(){
		
		$("#collapse-btn").click(function(){
			var toggle_menu = $(this).parent().children("#collapsed");
			if(toggle_menu.attr("toggled") =='true'){
				toggle_menu.attr("toggled" , 'false');
				toggle_menu.css('transform', 'scaleX(0)');
			}
			else{
				toggle_menu.attr("toggled" , 'true');
				toggle_menu.css('transform', 'scaleX(1)');
			
			}
		});
	});
</script>
-->

@endsection
@section('content')
<tr>
<th>id</th>
<th>name</th>
<th>description</th>
<th>price per DT</th>
<th>full quantity</th>
<th>ordered quntity</th>
<th>sold quantity</th>
<th>gains per DT</th>
<th>ratings</th>
<th width=200px>rate</th>
<th width=600px>image</th>
<th>added at</th>
<th>actions</th>
</tr>
@foreach($data as $row)

	
	<tr >
	<form enctype="multipart/form-data" method="post" action ="{{route('modify_product')}}">
		@csrf
		<th >{{$row["id"]}} <input name='id' type='number' value= {{$row["id"]}}></th>
		<th ><input type='text' value='{{$row["name"]}}' name='name' class="form-control"></th>
		<th ><textarea name='desc' class="form-control">{{$row['description']}}</textarea></th>
		<th ><input type='number' step=0.1  min-value=1 value='{{$row["price_per_DT"]}}' name='price_per_DT' class="form-control"></th>
		<th ><input type='number'   value='{{$row["full_quantity"]}}' name='full_quantity' class="form-control"></th>
		<th ><label  class="form-label">{{$row["ordered_quantity"]}} </label></th>
		<th ><label  class="form-label">{{$row["gains_per_DT"];}}</label></th>
		<th ><label class="form-label">{{ $row['ratings'] }}</label></th>
		<th ><label class="form-label">{{ $row['sold_quantity'] }}</label></th>
		<th >
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
		</th>
	
		<th class='d-flex'><input type='file' accept="image/png, image/jpeg" name='image' class="form-control mb-auto">
		@if( isset($row['image']))
		<img height= 150px src="{{asset('storage/img/'.$row['image'])}}">
		@else
		<img height= 150px src="{{asset('assets/img/iage.png')}}">
		@endif
		</th>
		<th><label class="form-label">{{$row["created_at"]}}</label></th>
		<th id='{{$row["id"]}}'> <button type="submit" class="btn btn-danger m-2" >modify</button> 
		<button type="button" class="btn btn-danger m-2 confirm" >delete</button></th>
	</form>
	</tr>

@endforeach
@endsection
@section('pagination')
{{$data->links()}}
@endsection