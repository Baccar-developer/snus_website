@extends('layouts.admin_layout')

@section('title')
Dashboard
@endsection
@section('content')
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
@foreach($data as $row)

	
	<tr id='{{$row["id"]}}'>
	<form enctype="multipart/form-data">
		<th >{{$row["id"]}}</th>
		<th ><input type='text' value='{{$row["name"]}}' name='name' class="form-control"></th>
		<th ><textarea name='desc' class="form-control">{{$row['description']}}</textarea></th>
		<th ><input type='number' step=0.1 value='{{$row["price_per_DT"]}}' name='price_per_DT' class="form-control"></th>
		<th ><input type='number' value='{{$row["full_quantity"]}}' name='full_quantity' class="form-control"></th>
		<th ><input type='number' value='{{$row["ordered_quantity"]}}' name='ordered_quantity' class="form-control"></th>
		<th ><input type='number' step=0.1 value='{{$row["gains_per_DT"];}}' name='gains_per_DT' class="form-control"></th>
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
	
		<th class='d-flex'><input type='file' accept="image/png, image/jpeg" name='name' class="form-control mb-auto">
		<img height= 150px src='{{asset("assets/img/".$row["image"])}}'>
		</th>
		<th><label class="form-label">{{$row["created_at"]}}</label></th>
		<th><button type="submit" value="modify" class="btn btn-danger m-2">modify</button> 
		<button type="submit" value="delete" class="btn btn-danger m-2">delete</button></th>
	</form>
	</tr>

@endforeach
@endsection