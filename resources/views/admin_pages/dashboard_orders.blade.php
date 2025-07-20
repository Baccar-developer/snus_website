<?php
use Carbon\Traits\Date;
?>
@extends("layouts.admin_layout")

@section("title")
orders dashboard
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
      <form method='post' action ="{{route('delete_order')}}" >
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
@endsection

@section('content')
<tr>
<th>id</th>
<th>product name</th>
<th>ordered at</th>
<th>time after ordering</th>
<th>order price per DT</th>
<th>governorate</th>
<th>location</th>
<th>state</th>
<th>delivered at</th>
<th>tel</th>
<th>payed</th>
<th>actions</th>
</tr>

@foreach($data as $row)
<tr>
    <th><label class='form-label'>{{$row['id']}}</label><input name='id' type='number' value= {{$row["id"]}}></th>
    <th><label class='form-label'>{{$row['product_name']}}</label></th>
    <?php 
        $order_date = $row['created_at'];
        $date = new DateTime('now');
        $diff = $date->diff($order_date);
    ?>
    <th><label class='form-label'>{{$order_date}}</label></th>
    <th>
    <label class='form-label'>
    <?php
    if($diff->y !=0){echo $diff->y." Years";}
    else if($diff->m !=0){echo $diff->m." Months";}
    else if($diff->d !=0){echo $diff->d." Days";}
    else {echo $diff->h." Hours ".$diff->i." minuts";}
    ?>
    </label>
    </th>
    <th><label class='form-label'>{{$row['order_price']}}</label></th>
    <th><label class='form-label'>{{$row['governorate']}}</label></th>
    <th><label class='form-label'>{{$row['location']}}</label></th>
    <th><label class='form-label text-<?php 
    	$state = $row["state"];
    	if($state =="delivered"){echo "success";}
    	else if($state =="unfulfilled"){echo "danger";}
    	else{echo "light-emphasis";}
    ?>
    '>{{$state}}</label></th>
    <th>{{$row['created_at']}}</th>
    <th>{{$row['tel']}}</th>
    <th>
    @if($row["payed"])
    	<label class="form-label text-success">payed</label>
    @else
    	<label class="form-label text-danger">not payed</label>
    @endif
    </th>
    <th id={{$row['id']}}>
    	@if($state=="unfulfilled")
    	    <a class='btn btn-danger' type='submit' href='{{route("check_order" , $row["id"])}}'>check</a>
    	@endif

    	<button class='btn btn-danger m-2 confirm' type="submit" >delete</button>
    </th>
</tr>

@endforeach
@endsection