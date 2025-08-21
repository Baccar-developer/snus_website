<?php
use Carbon\Traits\Date;
use App\Models\chart_elements;
use App\Models\products;

date_default_timezone_set("Africa/Tunis");
?>
@extends("layouts.admin_layout")

@section("title")
orders dashboard
@endsection

@section("custom")

<div class="modal" tabindex="1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-light bg-dark">
      <div class="modal-header">
        <h5 class="modal-title">confirm deletion</h5>
      </div>
      <div class="modal-body">
        <p>do you realy want to delete this order?</p>
      </div>
      <div class="modal-footer">
      <form method='post' action ="{{route('delete_order')}}" >
      @csrf
      @method("delete")
      <input type="number" name="order_id" style="display:none" id='id' step=1>
        <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <button type="button" class="btn btn-secondary" data-dismiss=".modal[tabindex='1']">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="2" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-light bg-dark">
      <div class="modal-header">
        <h5 class="modal-title">check order</h5>
      </div>
      <form method='post' action="{{route('check_order')}}">
      <div class="modal-body">
        <p>is this order delivered?</p>
        <p id="payed">is it payed? <input type="checkbox" name="payed" class="form-check-input" checked></p>
      </div>
      <div class="modal-footer">
      <input name="order_id" type="hidden" id="id2">
      @csrf
      @method("patch")
        <button type="submit" class="btn btn-danger">check</button>
        
        <button type="button" class="btn btn-secondary" data-dismiss=".modal[tabindex='2']">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		$(".modal-footer .btn-secondary").click(function(){
			$($(this).attr("data-dismiss")).hide();
		});
	});
</script>

<!-- ---filter inputs-------- -->
<form id="filter-bar" class="container-fluid d-flex align-items-center justify-content-center" method="get" action ="{{url('/admin/orders/filter')}}">
	<label>user name</label><input class="form-control" type="text" name="name" placeholder="search by name" style="width:200px !important" value="{{request('name')}}">
	<label>order status</label>
	<ul style="list-style :none; text-align:end">
		<li class="d-flex"><label class="text-success">delivered</label> <input class="form-check-input" type="radio" value="delivered" name="status" 
		 @if(request('status') =="delivered") checked @endif></li>
		<li  class="d-flex"><label class="text-warning">unfulfiled</label> <input class="form-check-input" type="radio" value="unfulfilled" name="status"
		 @if(request('status') =="unfulfilled") checked @endif></li>
		<li  class="d-flex"><label class="text-secondary">canceled</label> <input class="form-check-input" type="radio" value="canceled" name="status"
		 @if(request('status') =="canceled") checked @endif></li>
	</ul>
	<label class="ms-3 me-1"> order by order date:</label>ascend 
	@include("includes.switch_box" ,["name"=>"date_order" ,"checked"=>request("date_order")]) descend
	<label class="ms-3 me-1"> order by price:</label>ascend 
	@include("includes.switch_box" ,["name"=>"price_order", "checked"=>request("date_order")]) descend
	<button class="btn btn-danger ms-3" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
</form>


@endsection

@section('content')
<tr>
<th>id</th>
<th>user name</th>
<th>user avatar</th>
<th>products</th>
<th>ordered at</th>
<th>time after ordering</th>
<th>order price per DT</th>
<th>location</th>
<th>status</th>
<th>delivered at</th>
<th>tel</th>
<th>payed</th>
<th>actions</th>
</tr>

@foreach($data as $row)
<tr>
    <th><label class='form-label'>{{$row['order_id']}}</label><input name='id' type='number' value= {{$row["order_id"]}}></th>
    <th><label class="form-label">{{$row->customer_name}}</label></th>
    <th>@include("includes.avatar" ,["radius"=>"50px" , "avatar"=>$row->avatar])</th>
    <th>
    	<label class='form-label d-flex align-items-end' id="dropdown_bnt_{{$row->order_id}}" toggled="false"> products <i class="fa-solid fa-caret-down"></i></label>
    	<div id="drop_down_{{$row->order_id}}" style="overflow-y :hidden;height:0">
    		<?php 
    		$chart_elements = chart_elements::where("chart_id" ,$row->chart_id)
    		->leftJoin("products","products.product_id" ,"=" ,"chart_elements.product_id")
    		->get(["product_name" ,"qnt"]);
    		$height =0;
    		?>
    		@foreach($chart_elements as $c)
    		<div class="d-grid" style=" grid-template-columns:1fr 1fr">
    			<h5>{{$c->product_name}}</h5> <h5>{{$c->qnt}}</h5>
    			<?php $height += 40?>
    		</div>
    		@endforeach
    	</div>
    	
    	<script>
    		$("#dropdown_bnt_{{$row->order_id}}").click(function(){
    			if( $(this).attr("toggled") =="true"){
    				$(this).attr("toggled" ,"false");
    				$("#drop_down_{{$row->order_id}}").animate({height:0} , 400);
    			}
    			else{
    				$(this).attr("toggled" ,"true");
    				$("#drop_down_{{$row->order_id}}").animate({height: {{$height}}}, 400);
    			}
    		});
    	</script>
    </th>
    <?php 
        $order_date = $row['created_at'];
        $o = new DateTime($order_date);
        $date = new DateTime("now");
        $diff = date_diff($o ,$date );
    ?>
    <th><label class='form-label'>{{$order_date}}</label></th>
    <th>
    <label class='form-label'>
    <?php 
    
    if($diff->y !=0){echo $diff->y." Years";}
    else if($diff->m !=0){echo $diff->m." Months";}
    else if($diff->d !=0){echo $diff->d." Days";}
    else {
        if ($diff->h !=0){echo $diff->h." Hours ";}
        echo $diff->i." minuts";
    }
    ?>
    </label>
    </th>
    <th><label class='form-label'>{{$row['price_per_DT']}}</label></th>
    <th><label class='form-label'>{{$row['location']}}</label></th>
    <th><label class='form-label text-<?php 
    	$order_status = $row["order_status"];
    	if($order_status =="delivered"){echo "success";}
    	else if($order_status =="unfulfilled"){echo "warning";}
    	else{echo "light-emphasis";}
    ?>
    '>{{$order_status}}</label></th>
    <th>{{$row['delivered_at']}}</th>
    <th>{{$row['tel']}}</th>
    <th>
    @if($row["payed"])
    	<label class="form-label text-success">payed</label>
    @else
    	<label class="form-label text-danger">not payed</label>
    @endif
    </th>
    <th id={{$row['order_id']}}>
    	@if($order_status=="unfulfilled")
    	    <button class='btn btn-danger' type='submit' id="check_{{$row->order_id}}" payed={{$row->payed}}>check</button>
    	 <script>
    	$("#check_{{$row->order_id}}").click(function(){
			$(".modal[tabindex='2']").show();
			$("form #id2").attr( 'value',Number($(this).parent().attr("id")))  ;
			if($(this).attr("payed") == 1){$('#payed').hide()}
			else{$('#payed').show()}
			
		});
		</script>
    	@elseif( $row->order_status =='delivered' && $row->payed ==0)
    		<form method="post" action="{{route('is_payed')}}">
    		@method('PATCH')
    		@csrf
    		<input type="hidden" name='order_id' value='{{$row->order_id}}'>
    		<button class='btn btn-danger' type='submit' >payed</button>
    		</form>
    	@endif
		@if($row->order_status=="unfulfilled" && $row->payed==1)
    	<button class='btn btn-danger m-2 ' id="delete_{{$row->order_id}}" type="submit" >delete</button>
    	<script>
    	$("#delete_{{$row->order_id}}").click(function(){
			$(".modal[tabindex='1']").show();
			$("form #id").attr( 'value',Number($(this).parent().attr("id")))  ;
			
		});
		</script>
    	@endif
    </th>
</tr>

@endforeach
@endsection

@section('pagination')
{{$data->withQueryString()->links()}}
@endsection