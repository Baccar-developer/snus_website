<?php
use Carbon\Traits\Date;
use App\Models\chart_elements;
use App\Models\products;
?>
<table class="table table-dark table-striped fs-5">
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
</table>
{{$data->links()}}