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
        <button type="button" class="btn btn-secondary close" data-dismiss=".modal[tabindex=-1]" >Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal " tabindex="0" role="dialog">
  <div class="modal-dialog big" role="document">
    <div class="modal-content bg-dark text-light big">
      <div class="modal-header">
        <h5 class="modal-title">change description</h5>
      </div>
      <form method="post" action="{{route('desc_modify')}}">
      @csrf
      @method("put")
      <div class="modal-body">
      <input type="hidden" name="id" id="id">
        <textarea id="desc" name="desc" class="form-control" style="height:500px"></textarea>
      </div>
      <div class="modal-footer">
      
      <input type="number" name="id" style="display:none" id='id' step=1>
        <button type="submit" class="btn btn-danger">modify</button>
        </form>
        <button type="button" class="btn btn-secondary close" data-dismiss=".modal[tabindex=0]" >Close</button>
      </div>
    </div>
  </div>
</div>
<script>
	$('.close').click(function(){
		$($(this).attr('data-dismiss')).hide()
	});
	
</script>

<form class="container-flex d-flex align-items-center justify-content-center" id="filter_bar" method="get" action='{{url("/admin/products/filter")}}'>
		<label class="form-label text-danger fs-3">search :</label>
		
		<input class="form-control mr-sm-2" type="text" placeholder="Search" name="name"  style="width:200px" value="{{request('name')}}">
		<label class="form-label text-danger fs-3 mx-3"> order by rate: </label> 
		ascended @include('includes.switch_box',['name'=>"rate_order" , "checked"=>request('rate_order')])<label>descended</label>
		<label class="form-label text-danger fs-3 mx-3"> order by adding date: </label> 
		ascended @include('includes.switch_box',['name'=>"date_order" , "checked"=>request('date_order')])<label>descended</label>
		<button class="btn btn-danger ms-3" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
</form>

<div class="conteiner-fluid text-center"><a href="{{route('product_add_page')}}" class="btn btn-danger my-3">add product</a></div>

@endsection
@section('content')
<?php 
    use App\Models\orders;
    
    $date = new DateTime("now");
    $date = date_modify($date, "-".$date->format("d")." days");
    $date = date_time_set($date, 8, 0);
    $orders = orders::where("orders.created_at" , ">" , $date->format("Y-m-d h:i:s"))
    ->where("payed" ,1)
    ->rightJoin("chart_elements" ,"chart_elements.chart_id" ,"=" , "orders.chart_id")
    ->leftJoin("products" ,"products.product_id","=","chart_elements.product_id");

   
?>
<tr>
<th>name</th>
<th>description</th>
<th width=100px>price per DT</th>
<th width=100px>full quantity</th>
<th>wished quntity</th>
<th>ordered quantity</th>
<th >sold quantity</th>
<th>ratings</th>
<th style="min-width:200px">rate</th>
<th style="min-width:400px">image</th>
<th>added at</th>
<th>actions</th>
</tr>
@foreach($data as $row)

	
	<tr >
	<form enctype="multipart/form-data" method="post" action ="{{route('modify_product')}}">
		@csrf
		<input name='product_id' type='hidden' value= {{$row["product_id"]}}>
		<th ><input type='text' value='{{$row["product_name"]}}' name='product_name' class="form-control"></th>
		<th ><p class="btn btn-danger mt-2 desc_modify"  type="button">modify</p>
		<input type="hidden" value="{{$row->product_desc}}" id="desc">
		<input type="hidden" value="{{$row->product_id}}" id="id">
		</th>
		
		
		<th ><input type='number' step=0.1  min-value=1 value='{{$row["price_per_DT"]}}' name='price_per_DT' class="form-control"></th>
		<th ><input type='number'   value='{{$row["full_qnt"]}}' name='full_qnt' class="form-control"></th>
		<th ><label  class="form-label">{{$row["wished_qnt"]}} </label></th>
		<th ><label  class="form-label">{{$row["ordered_qnt"]}} </label></th>
		<th ><label class="form-label" style="overflow-x:scroll">
			<?php 
			     $o = clone $orders;
			     $qnt = $o->where("chart_elements.product_id" , $row->product_id)->sum("qnt");
			     
			     echo $qnt;
			?>
		</label></th>
		<th ><label class="form-label">{{ $row['ratings'] }}</label></th>
		<th >
			@include('includes.rate' ,['rate'=>$row->product_rate])
		</th>
	
		<th class='d-flex'><input type='file' accept="image/png, image/jpeg, image/webp" name='image' class="form-control mb-auto">
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
			$(".modal[tabindex=-1]").show();
			$("form #id").attr( 'value',Number({{$row->product_id}})) ;
			
		});
		</script>
	</form>
	</tr>

@endforeach
	<script>
    		$(".desc_modify").click(function(){
    			$(".modal[tabindex=0]").show();
    			$(".modal #desc").text($(this).parent().children("#desc").val());
    			$(".modal #id").val($(this).parent().children("#id").val());
    		});
		</script>
	
@endsection
@section('pagination')
{{$data->withQueryString()->links()}}
@endsection