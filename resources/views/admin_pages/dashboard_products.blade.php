@extends('layouts.admin_layout')

@section('title')
Dashboard
@endsection
@section("custom")

<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-dark text-light">
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
		
		$(".modal-footer .btn-secondary").click(function(){
			$(".modal").hide();
		});
		
		
	});
</script>
<div class="container-fluid m-3 text-center">
<a href="{{route('product_add_page')}}"><button class='btn btn-danger'>add new product</button></a>
</div>

<script>
		
		$(document).ready(function(){
    	var name_bar =$("#search");
    	var rate_button = $(".switch_button.rate_order input");
    	var date_button = $(".switch_button.date_order input");
    	
		function filter(){
			
    		dic = {
    			'name':name_bar.val(),
    			"rate_order":rate_button.val(),
    			"date_order" :date_button.val()
    		};
    		$.ajax({
    			url:"{{url('/admin/products/search')}}",
    			method:"get",
    			data: dic,
    			cache:false,
    			success:function(data){
    				if(data==''){$("#filter").html('<h3>no result</h3>')}
    				else{ $("#filter").html(data)}
    			},
    			error: function(xhr, ajaxOptions, thrownErro){
    				alert(xhr.status);alert(thrownErro);
    			}
    		});
    	}
    	
    	
    	$("#search").change( function(){setTimeout(filter , 100)});
    	
    	$(".switch_button").click(function(){setTimeout(filter , 100)});
    	});

	
</script>
<div class="container-flex d-flex align-items-center justify-content-center" id="filter_bar">
		<label class="form-label text-danger fs-3">search :</label>
		<input class="form-control mr-sm-2" type="text" placeholder="Search" id="search" style="width:200px">
		<label class="form-label text-danger fs-3 mx-3"> order by rate: </label> 
		ascended @include('includes.switch_box',['name'=>"rate_order"])<label>descended</label>
		<label class="form-label text-danger fs-3 mx-3"> order by adding date: </label> 
		ascended @include('includes.switch_box',['name'=>"date_order"])<label>descended</label>
</div>



@endsection
@section('content')
<tr>
<th>name</th>
<th>description</th>
<th width=100px>price per DT</th>
<th width=100px>full quantity</th>
<th>wished quntity</th>
<th>ordered quantity</th>
<th >sold quantity</th>
<th >gains per DT</th>
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
		<input name='product_id' type='hidden' value= {{$row["product_id"]}}>
		<th ><input type='text' value='{{$row["product_name"]}}' name='product_name' class="form-control"></th>
		<th ><textarea name='product_desc' class="form-control">{{$row['product_desc']}}</textarea></th>
		<th ><input type='number' step=0.1  min-value=1 value='{{$row["price_per_DT"]}}' name='price_per_DT' class="form-control"></th>
		<th ><input type='number'   value='{{$row["full_qnt"]}}' name='full_qnt' class="form-control"></th>
		<th ><label  class="form-label">{{$row["wished_qnt"]}} </label></th>
		<th ><label  class="form-label">{{$row["ordered_qnt"]}} </label></th>
		<th ><label class="form-label">{{ $row['sold_qnt'] }}</label></th>
		<th ><label  class="form-label">{{$row["gains_per_DT"];}}</label></th>
		<th ><label class="form-label">{{ $row['ratings'] }}</label></th>
		<th >
			@include('includes.rate' ,['rate'=>$row->product_rate])
		</th>
	
		<th class='d-flex'><input type='file' accept="image/png, image/jpeg" name='image' class="form-control mb-auto">
		@if( isset($row['product_image']))
		<img height= 150px src="{{asset('storage/product_img/'.$row['product_image'])}}">
		@else
		<img height= 150px src="{{asset('assets/img/img.png')}}">
		@endif
		</th>
		<th><label class="form-label">{{$row["created_at"]}}</label></th>
		<th id='{{$row["product_id"]}}'> <button type="submit" class="btn btn-danger m-2" >modify</button> 
		<button type="button" class="btn btn-danger m-2 " id="delete_{{$row->product_id}}" >delete</button></th>
		<script>
		$("#delete_{{$row->product_id}}").click(function(){
			$(".modal").show();
			$("form #id").attr( 'value',Number({{$row->product_id}})) ;
			
		});
		</script>
	</form>
	</tr>

@endforeach
@endsection
@section('pagination')
{{$data->links()}}
@endsection