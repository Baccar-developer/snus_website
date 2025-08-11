<?php
use Carbon\Traits\Date;
use App\Models\chart_elements;
use App\Models\products;
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
<div id="filter-bar" class="container-fluid d-flex align-items-center justify-content-center">
	<label>user name</label><input class="form-control" type="text" id="name" placeholder="search by name" style="width:200px !important">
	<label>order status</label>
	<ul style="list-style :none; text-align:end">
		<li><label class="text-success">delivered</label> <input class="form-check-input" type="radio" id="delivererd" name="status"></li>
		<li><label class="text-warning">unfulfiled</label> <input class="form-check-input" type="radio" id="unfulfilled" name="status"></li>
		<li><label class="text-secondary">canceled</label> <input class="form-check-input" type="radio" id="canceled" name="status"></li>
	</ul>
	<label class="ms-3 me-1"> order by order date:</label>ascend @include("includes.switch_box" ,["name"=>"date-order"])descend
	<label class="ms-3 me-1"> order by price:</label>ascend @include("includes.switch_box" ,["name"=>"price-order"])descend
</div>

<script>
	function filter(){
		dat={
			name : $("#name").val(),
			delivered : $("#delivererd").prop("checked"),
			unfulfilled : $("#unfulfilled").prop("checked"),
			canceled : $("#canceled").prop("checked"),
			date_order: $(".switch_button.date-order input").attr("value"),
			price_order: $(".switch_button.price-order input").attr("value"),
			_token :'{{csrf_token()}}'
			
		};
		$.ajax({
			url : "{{url('/admin/orders/filter')}}",
			method:'post',
			data :dat,
			success: function(data){ $("#filter").html(data)},
			error: function(xhr, ajaxOptions, thrownErro){ $("#filter").html( '<div class="container-fluid text-center fs-3">'+thrownErro+ '</div>')},
			dataType:'html'
		});
	}

	$("#filter-bar input").change(function(){
		filter()
	})
	
	$('.switch_button').click(function(){
		setTimeout(filter , 100);
	})
</script>

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
    	<div class="table table-dark table-striped" id="drop_down_{{$row->order_id}}">
    		<?php 
    		$chart_elements = chart_elements::where("chart_id" ,$row->chart_id)
    		->leftJoin("products","products.product_id" ,"=" ,"chart_elements.product_id")
    		->get(["product_name" ,"qnt"]);
    		$height =0;
    		?>
    		@foreach($chart_elements as $c)
    		<div class="d-grid" style="height:0; grid-template-columns:1fr 1fr">
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
        $date = new DateTime('now');
        $diff = $date->diff(new DateTime($order_date));
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
{{$data->links()}}
@endsection